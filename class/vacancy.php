<?php //vacancy.php
	include_once "eployer.php";

	class vacancy extends employer
	{
		public $universe_ID; //область знания
		public $work_type; //вид работ
		public $work_name; //название вида работ
		public $Description; //Требования - описание
		public $salary; //заработная плата
		public $occupation; //занятость

	}
?>