<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\ParentStudentRequest;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\ParentStudent\ParentStudentRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\ErrorMessageServices as Error;
use FutureEd\Services\MailServices;
use FutureEd\Services\InvoiceServices;
use Carbon\Carbon;
use FutureEd\Services\StudentServices;
use FutureEd\Services\SubscriptionServices;
use FutureEd\Services\UserServices;

class ParentStudentController extends ApiController {


    protected $class_student;
    protected $classroom;
    protected $client;
    protected $code;
    protected $invoice;
    protected $invoice_detail;
    protected $mail;
    protected $student;
    protected $student_service;
    protected $user;
    protected $order;
    protected $parent_student;
    protected $invoice_service;
    protected $order_details;
    protected $avatar;
    protected $subscription_service;
    protected $subscription_package;
    protected $user_service;

    public function __construct(
        StudentRepositoryInterface $student,
        ClientRepositoryInterface $client,
        UserRepositoryInterface $user,
        CodeGeneratorServices $code,
        MailServices $mail,
        ParentStudentRepositoryInterface $parent_student,
        ClassroomRepositoryInterface $classroom,
        OrderRepositoryInterface $order,
        ClassStudentRepositoryInterface $class_student,
        InvoiceRepositoryInterface $invoice,
        InvoiceDetailRepositoryInterface $invoice_detail,
        InvoiceServices $invoice_service,
        OrderDetailRepositoryInterface $order_details,
        AvatarServices $avatarServices,
        SubscriptionServices $subscriptionServices,
        SubscriptionPackageRepositoryInterface $subscriptionPackageRepositoryInterface,
        UserServices $userServices,
        StudentServices $studentServices
    ){

        $this->student = $student;
        $this->client = $client;
        $this->user = $user;
        $this->code = $code;
        $this->mail = $mail;
        $this->parent_student = $parent_student;
        $this->classroom = $classroom;
        $this->order = $order;
        $this->class_student = $class_student;
        $this->invoice = $invoice;
        $this->invoice_detail = $invoice_detail;
        $this->invoice_service = $invoice_service;
        $this->order_details = $order_details;
		$this->avatar = $avatarServices;
        $this->subscription_service = $subscriptionServices;
        $this->subscription_package = $subscriptionPackageRepositoryInterface;
        $this->user_service = $userServices;
        $this->student_service = $studentServices;
    }

    public function addExistingStudent(ParentStudentRequest $request){

        $data = $request->only('client_id','email');

        $client_detail = $this->client->getClientDetails($data['client_id']);

        //check if client_details is not empty
        if(!$client_detail){

            return $this->respondErrorMessage(2001);
        }

        //check if client_role is not Parent
        if($client_detail['client_role'] != config('futureed.parent')){

            return $this->respondErrorMessage(2032);
        }

        //returns user id
        $check_email = $this->user->checkEmail($data['email'], config('futureed.student'));

        //check if check_email is not empty
        if(!$check_email){

            return $this->respondErrorMessage(2002);
        }

        //get the student id using $check_email since $check_email content user_id
        $student_id = $this->student->getStudentId($check_email);

        //get user details
        $user_detail = $this->user->getUserDetail($check_email,config('futureed.student'));

        $parent_student_id = $this->parent_student->checkParentStudent($data['client_id'],$student_id);

        //if parent_student_id has value it means that parent already added a student
        if($parent_student_id){

            return $this->respondErrorMessage(2131);
        }

        //generate invitation_code
        $invitation_code = $this->code->getCode();

        //form data needed for adding (parent_id,student_id,invitation_code,status)
        $details['parent_id'] = $data['client_id'];
        $details['student_id'] = $student_id;
        $details['invitation_code'] = $invitation_code;
        $details['status'] = config('futureed.user_disabled');

        //add data to parent_students table
        $return = $this->parent_student->addParentStudent($details);

        //send email to student
        $this->mail->sendParentAddStudent($user_detail,$client_detail,$invitation_code);

        return $this->respondWithData(['id'=>$return['id']]);
    }

    public function parentConfirmStudent(ParentStudentRequest $request){

        $data = $request->only('client_id','invitation_code');

        $client_detail = $this->client->getClientDetails($data['client_id']);

        //check if client_details is not empty
        if(!$client_detail){

            return $this->respondErrorMessage(2001);
        }

        $parent_student_detail = $this->parent_student->checkInvitationCode($data['invitation_code'],$data['client_id']);

        //check if parent_student_detail is empty
        if(!$parent_student_detail){

            return $this->respondErrorMessage(2132);
        }

        $parent_student['status'] = config('futureed.user_enabled');
        $parent_student['invitation_code'] = NULL;

        //if client_id and invitation_code is correct update parent_student table
        $return = $this->parent_student->updateParentStudent($parent_student_detail['id'],$parent_student);

        return $this->respondWithData($return);

    }

    public function parentUpdateStudent($id,ParentStudentRequest $request){

        $student = $request->only('first_name','last_name','birth_date','gender','country_id','state','city');

        $user = $request->only('username');
        $user['name'] = $student['first_name'] .' '. $student['last_name'];

        //get student details
        $student_detail = $this->student->viewStudent($id);

        //check if student is empty
        if(!$student_detail){

            return $this->respondErrorMessage(2001);
        }

        //update username and name to user's table
        $this->user->updateUser($student_detail['user_id'],$user);

        $this->student->updateStudentDetails($id,$student);

        //get the updated student details
        return $this->respondWithData($this->student->viewStudent($id));
    }

    /**
     * Add payment by parent.
     *
     * @param ParentStudentRequest $request
     * @return mixed
     * @internal param $id
     */
    public function paySubscription(ParentStudentRequest $request)
    {
        /**
         * 1. create order
         * 2. create order details
         * 3. create invoice
         * 4. create invoice details
         * 5. classroom
         * 6. class_student
         */

        $order = $request->all();

        //create order
        $prev_order = $this->order->getLastOrderNo();

        if(!$prev_order){

            $next_order_id = 1;
        }else{

            $next_order_id = ++$prev_order['id'];
        }

        $order['date_start'] = Carbon::now()->toDateTimeString();
        $order['date_end'] = Carbon::now()->addDays($order['date_end'])->toDateTimeString();


        if (!isset($order['save'])) {

            $order['payment_status'] = $this->subscription_service->checkPriceValue($order['total_amount']);
        }

        $order['order_no'] = $this->invoice_service->createOrderNo($order['client_id'],$next_order_id);

        $new_order = $this->order->addOrder($order);

        //create order details
        foreach($order['students'] as $student){

            //insert data to order_details table
            $this->order_details->addOrderDetail([
                'order_id' => $new_order['id'],
                'student_id' => $student['id'],
                'price' => $student['price']
            ]);

        }

        $client = $this->client->getClientDetails($order['client_id']);

        //create invoice
        $invoice = [
            'order_no' => $order['order_no'],
            'invoice_date' => $order['order_date'],
            'client_id' => $order['client_id'],
            'client_name' => $client->user->name,
            'date_start' => $order['date_start'],
            'date_end' => $order['date_end'],
            'seats_total' => $order['seats_total'],
            'total_amount' => $order['total_amount'],
            'subscription_id' => $order['subscription_id'],
            'payment_status' => $order['payment_status'],
            'subscription_package_id' => $order['subscription_package_id'],
            'discount_id' => isset($order['discount_id']) ? $order['discount_id'] : 0,
            'discount' => isset($order['discount']) ? $order['discount'] : 0
        ];

        //insert data to invoices table
        $inserted_invoice = $this->invoice->addInvoice($invoice);

        //insert new classroom
        $classroom = [
            'order_no' => $order['order_no'],
            'name' => config('futureed.STU').Carbon::now()->timestamp,
            'grade_id' => config('futureed.true'),
            'client_id' => $order['client_id'],
            'subject_id' => $order['subject_id'],
            'seats_taken' => $order['seats_taken'],
            'seats_total' => $order['seats_total']
        ];

        //insert data to classrooms table
        $inserted_classroom = $this->classroom->addClassroom($classroom);

        //form data for class_students
        foreach($order['students'] as $student){

            $this->class_student->addClassStudent([
                'student_id' => $student['id'],
                'class_id' => $inserted_classroom['id'],
                'date_started' => $order['order_date'],
                'subscription_status' => config('futureed.active')
            ]);

            //check students for null curriculum country
            $this->student_service->checkStudentCurriculum($student['id'],$order['country_id']);

        }

        //insert invoice details
        //form data for invoice detail
        $invoice_detail = [
            'invoice_id' => $inserted_invoice['id'],
            'class_id' => $inserted_classroom['id'],
            'grade_id' => config('futureed.true'),
            'price' => $order['total_amount']
        ];

        //insert data to invoice_detail
        $this->invoice_detail->addInvoiceDetail($invoice_detail);

        //get country on subscription package
        $subscription = $this->subscription_package->getSubscriptionPackage($order['subscription_package_id']);

        //updated user curr id
        $this->user_service->updateCurriculumCountry($client->user_id,$subscription->country_id);

        return $this->respondWithData($inserted_invoice);
    }

    /**
     * get list by parent user id
     *
     * @param $order_no
     * @return mixed
     * @internal param $parent_id
     */
    public function getStudents($order_no){
        $order = $this->order->getOrderByOrderNo($order_no);
        return $this->respondWithData($this->order_details->getOrderDetailsByOrderId($order['id']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
        return $this->respondWithData($this->parent_student->deleteParentStudent($id));
    }

    /**
     * Remove resource from storage by parent user id
     * @param $parent_id
     * @return Response
     */
    public function deleteStudentByParentId($parent_id){
        return $this->respondWithData($this->parent_student->deleteParentStudentByParentId($parent_id));
    }

    /**
     * Add student with id.
     * @param ParentStudentRequest $request
     * @return mixed
     */
    public function addStudent(ParentStudentRequest $request){

        $student_id = $request->only('student_id');

        $student_user_id = $this->student->getUserId($student_id);

        $parent_id = $request->only('parent_id');

        $subject_id = $request->only('subject_id');

        $order_id = $request->only('order_id');

        $order_details = $request->all();


        //check if user is associated to the parent.
        $check_parent_student = $this->parent_student->checkParentStudent($parent_id,$student_id);

        if(is_null($check_parent_student)){
            return $this->respondErrorMessage(2039);
        }

        // check if student have current subscription of a subject
        $class_student_subject = $this->classroom->getClassroomBySubjectId($subject_id, $student_id);

        if($class_student_subject){
            return $this->respondErrorMessage(2037);
        }

        $check_order_detail = $this->order_details->getOrderDetailByOrderIdAndStudentId($order_id['order_id'],$student_id);
        if(!is_null($check_order_detail)){
            return $this->respondErrorMessage(2040);
        }

        // Add order details
        $order_details['student_id'] = $student_id;
        $this->order_details->addOrderDetail($order_details);

        return $this->respondWithData($this->user->getUserDetail($student_user_id,config('futureed.student')));

    }

    /**
     * Add student to invoice by email. check if the student is associated to the parent and it has no current subscription.
     * @param ParentStudentRequest $request
     * @return Student Record
     *
     */
    public function addStudentByEmail(ParentStudentRequest $request){
        $email = $request->only('email');

        $student_user_id = $this->user->checkEmail($email,config('futureed.student'));

        if(is_null($student_user_id)){
            return $this->respondErrorMessage(2002);
        }

        $student_id = $this->student->getStudentId($student_user_id);

        $parent_id = $request->only('parent_id');//this is a client id

        $subject_id = $request->only('subject_id');

        //check if user is associated to the parent.
        $check_parent_student = $this->parent_student->checkParentStudent($parent_id,$student_id);

        if(is_null($check_parent_student)){
            return $this->respondErrorMessage(2039);
        }


        // check if student have current subscription of a subject
        $class_student_subject = $this->classroom->getClassroomBySubjectId($subject_id, $student_id);

        if ($class_student_subject) {

	       return $this->respondErrorMessage(2037);
        }

        $order_id = $request->only('order_id');
        $check_order_detail = $this->order_details->getOrderDetailByOrderIdAndStudentId($order_id['order_id'],$student_id);
        if(!is_null($check_order_detail)){
            return $this->respondErrorMessage(2040);
        }

        // Add order details
        $order_details = $request->all();
        $order_details['student_id'] = $student_id;
        $this->order_details->addOrderDetail($order_details);

        return $this->respondWithData($this->user->getUserDetail($student_user_id,config('futureed.student')));
    }

    /**
     * Add student to invoice by name. check if the student is associated to the parent and it has no current subscription.
     * @param ParentStudentRequest $request
     * @return Student Record
     *
     */
    public function addStudentByName(ParentStudentRequest $request){

        $user_name = $request->only('username');

        $student_user_id = $this->user->checkUserName($user_name,config('futureed.student'));

        if(is_null($student_user_id)){
            return $this->respondErrorMessage(2018);
        }

        $student_id = $this->student->getStudentId($student_user_id);

        $parent_id = $request->only('parent_id');

        $subject_id = $request->only('subject_id');

        //check if user is associated to the parent.
       $check_parent_student = $this->parent_student->checkParentStudent($parent_id,$student_id);

        if(is_null($check_parent_student)){
            return $this->respondErrorMessage(2039);
        }

        // check if student have current subscription of a subject
        $class_student_subject = $this->classroom->getClassroomBySubjectId($subject_id, $student_id);

        if($class_student_subject){

           return $this->respondErrorMessage(2037);
        }

        $order_id = $request->only('order_id');
        $check_order_detail = $this->order_details->getOrderDetailByOrderIdAndStudentId($order_id['order_id'],$student_id);
        if(!is_null($check_order_detail)){
            return $this->respondErrorMessage(2040);
        }

        // Add order details
        $order_details = $request->all();
        $order_details['student_id'] = $student_id;
        $this->order_details->addOrderDetail($order_details);

        return $this->respondWithData($this->user->getUserDetail($student_user_id,config('futureed.student')));
    }

	public function getStudentList($id){

		$criteria['parent_id'] = $id;
		$student_list = $this->parent_student->getParentStudents($criteria);

		//check if parent has student
		if (empty($student_list->toArray())) {

			return $this->respondErrorMessage(2130);
		}

		foreach($student_list as $list => $students){

			if($students->student->avatar <> NULL) {

				$students->student->avatar->url = $this->avatar->getAvatarThumbnailUrl($students->student->avatar->avatar_image);
			}
		}

		return $this->respondWithData($student_list);
	}
}