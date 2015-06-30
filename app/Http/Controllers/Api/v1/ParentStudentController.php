<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\InvoiceRequest;
use FutureEd\Http\Requests\Api\ParentStudentRequest;
use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\ParentStudent\ParentStudentRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\InvoiceServices;

class ParentStudentController extends ApiController {


    protected $class_student;
    protected $classroom;
    protected $client;
    protected $code;
    protected $invoice;
    protected $invoice_detail;
    protected $mail;
    protected $student;
    protected $user;
    protected $order;
    protected $parent_student;
    protected $invoice_service;
    protected $order_details;
	protected $avatar;

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
		AvatarServices $avatarServices){

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
     * @param InvoiceRequest $request
     * @return mixed
     */
    public function paySubscription($id,ParentStudentRequest $request)
    {
        $order_data = $request->only('order_no');
        $order_no = $this->order->getOrderByOrderNo($order_data['order_no']);

        $order_details = $this->order_details->getOrderDetailsByOrderId($order_no['id']);

        $order_details_ctr = $order_details->count();
        if($order_details_ctr == 0){
            return $this->respondErrorMessage(2038);
        }

        /**
         * TODO:
         * 1. Insert Classroom.
         * 2. Insert Class Student.
         * 3. Insert Order.
         * 4. Insert Invoice.
         * 5. Insert Invoice Details.
         */

        $parent_student_data = $request->all();

        //1. Insert Classroom.

        $client_id = $this->client->getClientId($parent_student_data['parent_id']);

        $order_no = $order_no['order_no'];

        $check_classroom = $this->classroom->getClassroomByOrderNo($order_no);

        $classroom['order_no'] = $order_no;
        $classroom['name'] = 'NONE';
        $classroom['grade_id'] = 1;
        $classroom['client_id'] = $client_id;
        $classroom['seats_taken'] = $order_details_ctr;
        $classroom['seats_total'] = $order_details_ctr;
        $classroom['status'] = 'Enabled';

        if(is_null($check_classroom)){
            $classroom_result = $this->classroom->addClassroom($classroom);
        }else{
            $classroom_result = $this->classroom->updateClassroom($check_classroom['id'],$classroom);
        }

        //2. Insert Class Student.
        foreach($order_details as $stud){

            $check_class_student = $this->class_student->getClassStudent($stud->student->id);
            if(is_null($check_class_student)){
                $class_student['student_id'] = $stud->student->id;
                $class_student['class_id'] = $classroom_result->id;
                $class_student['status'] = 'Enabled';

                $this->class_student->addClassStudent($class_student);
                unset($class_student);
            }
        }

        //3. Insert Order.
        $order['order_no'] = $order_no;
        $order['order_date'] = $parent_student_data['order_date'];
        $order['client_id'] = $client_id;
        $order['subscription_id'] = $parent_student_data['subscription_id'];
        $order['date_start'] = $parent_student_data['date_start'];
        $order['date_end'] = $parent_student_data['date_end'];
        $order['seats_total'] = $order_details_ctr;
        $order['seats_taken'] = $order_details_ctr;
        $order['total_amount'] = $parent_student_data['total_amount'];
        $order['payment_status'] = 'Pending';

        //dd($order);
        $check_order = $this->order->getOrderByOrderNo($order_no);

        if( !is_null($check_order) ){
            $this->order->updateOrder($check_order['id'],$order);
        }else{
            $this->order->addOrder($order);
        }

        //4. Insert Invoice.

        $client_details = $this->client->getClientDetails($client_id);

        $invoice_id = $id;
        $invoice['order_no'] = $order_no;
        $invoice['invoice_date'] = $parent_student_data['order_date'];
        $invoice['client_id'] = $client_id;
        $invoice['client_name'] = $client_details->first_name .' '.$client_details->last_name;
        $invoice['date_start'] = $parent_student_data['date_start'];
        $invoice['date_end'] = $parent_student_data['date_end'];
        $invoice['seats_total'] = $order_details_ctr;
        $invoice['discount_type'] = $parent_student_data['discount_type'];
        $invoice['discount_id'] = $parent_student_data['discount_id'];
        $invoice['discount'] = $parent_student_data['discount'];
        $invoice['total_amount'] = $parent_student_data['total_amount'];
        $invoice['subscription_id'] = $parent_student_data['subscription_id'];
        $invoice['payment_status'] = 'Pending';

        $invoice_result = $this->invoice->updateInvoice($invoice_id,$invoice);

        //5. insert Invoice Detail.
        $check_invoice_detail = $this->invoice_detail->getInvoiceDetailByInvoiceIdAndClassId($id,$classroom_result->id);
        if(is_null($check_invoice_detail)) {
            $order_detail['invoice_id'] = $invoice_id;
            $order_detail['class_id'] = $classroom_result->id;
            $order_detail['grade_id'] = $classroom_result->grade_id;
            $order_detail['price'] = $parent_student_data['total_amount'];

            $this->invoice_detail->addInvoiceDetail($order_detail);
        }


        return $this->respondWithData($invoice_result);
    }

    /**
     * get list by parent user id
     *
     * @param $parent_id
     * @return mixed
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

        //check if user is associated to the parent.
        $check_parent_student = $this->parent_student->checkParentStudent($parent_id,$student_id);

        if(is_null($check_parent_student)){
            return $this->respondErrorMessage(2039);
        }

        // check if student has existing subscription
        $check_class_student = $this->student->subscriptionExpired($student_id);

        if($check_class_student){
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

        //check if user is associated to the parent.
       $check_parent_student = $this->parent_student->checkParentStudent($parent_id,$student_id);

        if(is_null($check_parent_student)){
            return $this->respondErrorMessage(2039);
        }

        // check if student has existing subscription
        $check_class_student = $this->student->subscriptionExpired($student_id);
        if($check_class_student){
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

	//TODO: 711
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