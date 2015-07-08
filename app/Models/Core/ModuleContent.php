<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleContent extends Model {

	use SoftDeletes;

	protected $table = 'module_contents';

	protected $dates = ['created_at','updated_at','deleted_at'];


//+------------+----------------------------+------+-----+---------------------+----------------+
//| Field      | Type                       | Null | Key | Default             | Extra          |
//+------------+----------------------------+------+-----+---------------------+----------------+
//| id         | bigint(20) unsigned        | NO   | PRI | NULL                | auto_increment |
//| module_id  | bigint(20)                 | NO   |     | NULL                |                |
//| subject_id | bigint(20)                 | NO   |     | NULL                |                |
//| grade_id   | bigint(20)                 | NO   |     | NULL                |                |
//| area_id    | bigint(20)                 | NO   |     | NULL                |                |
//| content_id | bigint(20)                 | NO   |     | NULL                |                |
//| seq_no     | bigint(20)                 | NO   |     | NULL                |                |
//| status     | enum('Enabled','Disabled') | NO   |     | NULL                |                |
//| created_by | bigint(20)                 | NO   |     | NULL                |                |
//| updated_by | bigint(20)                 | NO   |     | NULL                |                |
//| deleted_at | timestamp                  | YES  |     | NULL                |                |
//| created_at | timestamp                  | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at | timestamp                  | NO   |     | 0000-00-00 00:00:00 |                |
//+------------+----------------------------+------+-----+---------------------+----------------+


}
