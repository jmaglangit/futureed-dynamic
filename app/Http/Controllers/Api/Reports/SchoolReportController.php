<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SchoolReportController extends Controller {

	public function __construct(){}

		//-- Key Skills to watch
		//-- Average of progress of subject area of the whole school
		//
		//select
		//sm.student_id, sm.subject_id, sm.module_id, sm.progress
		//,m.grade_id as m_grade_id, m.code as m_code, m.name as m_name, m.subject_area_id
		//,sa.id as sa_id, sa.code as sa_code,sa.name as sa_name
		//,c.id as c_id,c.name as c_name
		//,st.first_name, st.last_name, st.school_code
		//from student_modules sm
		//left join modules m on m.id=sm.module_id
		//left join subject_areas sa on sa.id=m.subject_area_id
		//left join classrooms c on c.id = sm.class_id
		//left join orders o on o.order_no=c.order_no
		//left join students st on st.id=sm.student_id and st.school_code is not null
		//where
		//sm.module_status <> 'Failed'
		//and sm.deleted_at is null
		//and date(o.date_start) <= now() and date(o.date_end) >= now()
		//and school_code = 1
		//
		//;


}
