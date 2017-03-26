<?php 
class Judge 
{ 
   protected $id;
   protected $name;
   protected $plus;
   protected $minus;

/* 
Costruttore
*/ 
	function __construct($idJ, $nameJ) {
		$this->id = $idJ;
		$this->name = $nameJ;
		$this->plus = 0;
		$this->minus = 0;
	} 
	
	function getId() {
		return $this->id;
	}
	
	function getTotal() {
		return $this->plus - $this->minus;
	}
	
	function addPlus() {
		$this->plus++;
	}
	
	function addMinus() {
		$this->minus--;
	}
	
	function getPlus() {
		return $this->plus;
	}
	
	function getMinus() {
		return $this->minus;
	}
	
	function getName() {
		return $this->name;
	}
	
	function printJudge()
	{
		return $this->name." ".$this->plus." ".$this->minus." = ".$this->getTotal()."<br>";
	}

}//END class

class JudgeMatrix 
{ 
   protected $numJudges;
   protected $point1;
   protected $point2;
   protected $point3;
   protected $point4;
   protected $point5;
   
   protected $total;
   protected $average;

/* 
Costruttore
*/ 
	function __construct($numJ, $p1, $p2, $p3, $p4, $p5) {
		$this->numJudges = $numJ;
		$this->point1 = $p1;
		$this->point2 = $p2;
		$this->point3 = $p3;
		$this->point4 = $p4;
		$this->point5 = $p5;
		
		//calcolo
		if($this->numJudges==3)
		{
			$this->total=$this->point1 + $this->point2 + $this->point3;
		}
		else //5
		{
			$v[0]=$this->point1;
			$v[1]=$this->point2;
			$v[2]=$this->point3;
			$v[3]=$this->point4;
			$v[4]=$this->point5;
			
			$this->total=$this->point1 + $this->point2 + $this->point3 + $this->point4 + $this->point5 - (max($v) + min($v));
		}
		$this->average = $this->total / 3;
	}
	
	function getP1(){
		return $this->point1;
	}
	function getP2(){
		return $this->point2;
	}
	function getP3(){
		return $this->point3;
	}
	function getP4(){
		return $this->point4;
	}
	function getP5(){
		return $this->point5;
	}
	
	function getTotal() {
		return $this->total;
	}
	
	function getAverage() {
		return $this->average;
	}
	
	function printMatrix() {
		if($this->numJudges==3)
			return "<tr><td>".$this->point1."</td><td>".$this->point2."</td><td>".$this->point3."</td><td>".$this->total."</td><td>".round($this->average, 2)."</td></tr>";
		else
			return "<tr><td>".$this->point1."</td><td>".$this->point2."</td><td>".$this->point3."</td><td>".$this->point4."</td><td>".$this->point5."</td><td>".$this->total."</td><td>".round($this->average, 2)."</td></tr>";
	}

}//END class 

function findJudge($array, $idj)
{
	$i=0;
	foreach($array as $val)
	{
		if($val->getId()==$idj)
			return $i;
		$i++;
	}
	return -1;
}

//funzione per ordinare Judge
function cmpJudge($a, $b)
{
    if ($a->getTotal() == $b->getTotal()) {
        return 0;
    }
    return ($a->getTotal() < $b->getTotal()) ? -1 : 1;
}
?>
