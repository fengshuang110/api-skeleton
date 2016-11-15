<?php 
namespace Application\Service;
use Application\Model\Section;
use Application\Model\SectionQuestion;
class TikuService extends BaseService{
	
	public static $instance = null;
	protected $cache = null;
	const SINGLE_QUESTION_NUM = 5;
	public  $jiaocaiMap = array(
		'1'=>'489',
		'2'=>'543',
		'3'=>'491',
		'4'=>'492',
		'5'=>'15',
		'6'=>'494',
	);
	
	private function __construct(){
	}
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new TikuService();
		}
		return self::$instance;
	}
	
	public function getMap($grade){
		if(!key_exists($grade, $this->jiaocaiMap)){
			return -1;
		}
		$jiaocaiId = $this->jiaocaiMap[$grade];
		$sections = Section::where('grade_no', $grade)->where('slevel', 2)->where('jiaocai_id',$jiaocaiId)->get();
		$ret = array();
		foreach ($sections as $section){
			$ret[] = array(
				'sectionId'=>$section->section_id,
				'sectionName'=>$section->section_name,	
			);
		}
		return $ret;
	}
	
	public function getMapLevel($sectionId){
		$sections = Section::where('slevel', 3)
					->whereNull('relate_sections')
					->where('question_count','>',0)
					->where('parent_id',$sectionId)->get();
		$ret = array();
		foreach ($sections as $section){
			$ret[] = array(
				'sectionId'=>$section->section_id,
				'sectionName'=>$section->section_name,
				'questionCount'=>$section->question_count
			);
		}
		return $ret;
	}
	
	public function getQuestionBysection($sectionId){
		$limit = 10;
		$questions = SectionQuestion::where('question_type','FillIn')
							->where('section_id', $sectionId)
							->orderByRaw('RAND()')
							->take($limit)
							->get();
		$reData = array();
		foreach ($questions as $question){
			$temp = array();
			$temp['questionId'] = $question->question_id;
			$temp['question'] = $question->question;
			$temp['rightRate'] =  $question->right_rate;
			$temp['rightAnswer'] = $question->right_answer;
			$reData[] = $temp;
		}
		return $reData;
		
	}
	
	
	private function calculationGrade(){
		return 1;
	}
	
	public function getRandSection10($gradeNo = ''){
		if(empty($gradeNo)){
			return -1;
		}
		return Section::where('grade_no', $gradeNo)
			->where('slevel', 3)->whereNull('relate_sections')
			->where('question_count','>',0)
		    ->orderByRaw('RAND()')
		    ->take(10)
		    ->get();
		
	}
	/**
	 * 通过年级获取
	 * @param unknown $grade_no
	 */
	public function getQuestions(){
		$gradeNo = $this->calculationGrade();
		$sections = $this->getRandSection10($gradeNo);
		foreach($sections as $section){
			$sectionIds[] = $section->section_id;
		}
		$limit = self::SINGLE_QUESTION_NUM * count($sectionIds);
		$questions = SectionQuestion::where('question_type','FillIn')->whereIn('section_id', $sectionIds)
							->orderByRaw('RAND()')
						    ->take($limit)
						    ->get();
		$reData = array();
		foreach ($questions as $question){
			$temp = array();
			$temp['questionId'] = $question->question_id;
			$temp['question'] = $question->question;
			$temp['rightRate'] =  $question->right_rate;
			$temp['rightAnswer'] = $question->right_answer;
			$reData[] = $temp;
		}
		return $reData;
					    
	}
}


?>