<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'exam';
    }

    public function create_schedule($data)
    {
    	$subjects = $data['subject'];
        $students = $this->db->query("SELECT std_id, class_id FROM student_class WHERE class_id IN ({$data['classroom']})")->result();
    	unset($data['subject']);
    	$this->db->trans_start();
    	$this->db->insert($this->_table, $data);
    	$insert_id = $this->db->insert_id();
    	foreach ($subjects as $key => $value) {
    		$subjects[$key]['exam'] = $insert_id;
    	}
        $std = [];
        foreach ($subjects as $key => $value) {
            foreach($students as $key => $student){
                array_push($std, ['subject'=>$value['subject'], 'exam'=>$insert_id, 'student'=>$student->std_id, 'class'=>$student->class_id]);
            }
        }
		$this->db->insert_batch('exam_details', $subjects);
        $this->db->insert_batch('exam_student', $std);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
		    return false;
		}else{
			return true;
		}
    }

    public function update_schedule($data)
    {
        $subjects = $data['subject'];
        unset($data['subject']);
        $this->db->trans_start();
        $this->db->update($this->_table, $data, ['id'=>$data['id']]);
        foreach ($subjects as $key => $value) {
            $subjects[$key]['exam'] = $data['id'];
        }
        $this->db->delete('exam_details',array('exam' => $data['id']));
        $this->db->insert_batch('exam_details', $subjects);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }else{
            return true;
        }
    }

    public function get_sub_by_exam($id)
    {
        $this->db->select('exam_details.*, subject.title as sub');
        $this->db->from('exam_details');
        $this->db->join('subject', 'subject.id=exam_details.subject', 'left');
        $this->db->where('exam_details.exam', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function exam_results($id, $std)
    {
        $this->db->select('exam_student.*, subject.title as sub');
        $this->db->from('exam_student');
        $this->db->join('subject', 'subject.id=exam_student.subject', 'left');
        $this->db->where('exam_student.exam', $id);
        $this->db->where('exam_student.student', $std);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_schedule()
    {
    	$this->db->select('exam.*, classroom.title as class_title, classroom.division');
    	$this->db->from('exam');
    	$this->db->join('classroom', 'classroom.id=exam.classroom', 'left');
    	$query = $this->db->get();
    	return $query->result();

    }

    public function get_report()
    {
    	$this->db->select('exam.*, classroom.title as class_title, classroom.division');
    	$this->db->from('exam');
    	$this->db->join('classroom', 'classroom.id=exam.classroom', 'left');
        $this->db->where('complete', 1);
    	$query = $this->db->get();
    	return $query->result();
    }


    public function get_student_results($exam=null, $student=null, $subject=null)
    {
        $this->db->select('std.id, CONCAT(std.firstname," ",std.lastname) as name, sub.id as sub_id,  sub.title as subject, CONCAT(cls.title,"-" ,cls.division) as class, es.marks');
    	$this->db->from('exam_student es');
        $this->db->join('student std', 'std.id=es.student', 'left');
        $this->db->join('subject sub', 'es.subject=sub.id', 'left');
        $this->db->join('classroom cls', 'es.class=cls.id', 'left');
        if($student <> null)
            $this->db->where('es.student', $student);
        if($subject <> null)
            $this->db->where('es.subject', $subject);
        if($exam <> null)
            $this->db->where('es.exam', $exam);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function subsByExam($exam){
		$this->db->select('subject.id, subject.title');
		$this->db->from('exam_details');
		$this->db->join('subject', 'subject.id=exam_details.subject','left');
		$this->db->where('exam', $exam);
        $this->db->group_by('subject.id');
		$query = $this->db->get();
		return $query->result();
	}

    public function studsByExam($exam){
		$this->db->select('student.id, CONCAT(student.firstname," ",student.lastname) as name');
		$this->db->from('exam_student');
		$this->db->join('student', 'student.id=exam_student.student','left');
		$this->db->where('exam', $exam);
         $this->db->group_by('student.id');
		$query = $this->db->get();
		return $query->result();
	}

    public function updateMarks($data){
        foreach ($data as $row) {
			$this->db->update('exam_student', $row, ['student' => $row['student'], 'subject' => $row['subject']]);
		}
		if($this->db->affected_rows() > -1)
    		return true;
		else
			return false;
    }
}