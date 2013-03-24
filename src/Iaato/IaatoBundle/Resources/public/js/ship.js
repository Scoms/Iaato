/**
 * @overview
 *
 * @author 
 * @version 2013/03/24
 */


$(document).ready(function () {

		$('#linklistship').click(function () {
			$('#listship').animate({ height: "100%" }, 500).css('display','block');
			$('#changeship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#changeship').css('display','none');
			});
			$('#deleteship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#deleteship').css('display','none');
			});	
			$('#addship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#addship').css('display','none');
			});			
		});
*/		
		$('#linkaddship').click(function () {
			$('#addship').animate({ height: "150px" }, 500).css('display','block');
			$('#changeship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#changeship').css('display','none');
			});
			$('#deleteship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#deleteship').css('display','none');
			});	
			$('#listship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#listship').css('display','none');
			});
			/*			
			$('#remonteaddship').click(function () {
				$('#addship').animate({ 
					height: "0px" 
				}, 500, function() {
						$('#addship').css('display','none');
					});
			});
			*/
		});	
		
		$('#linkchangeship').click(function () {
			$('#changeship').animate({ height: "200px" }, 500).css('display','block');
			$('#addship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#addship').css('display','none');
			});
			$('#deleteship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#deleteship').css('display','none');
			});	
			$('#listship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#listship').css('display','none');
			});
			/*			
			$('#remontemodifmar').click(function () {
				$('#modifmar').animate({ 
					height: "0px" 
				}, 500, function() {
						$('#modifmar').css('display','none');
					});
			});*/
		});

		$('#linkdeleteship').click(function () {
			$('#deleteship').animate({ height: "150px" }, 500).css('display','block');
			$('#changeship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#changeship').css('display','none');
			});
			$('#addship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#addship').css('display','none');
			});	
			$('#listship').animate({ 
				height: "0px" 
			}, 500, function() {
					$('#listship').css('display','none');
			});			
			/*
			$('#remontesupmar').click(function () {
				$('#supmar').animate({ 
					height: "0px" 
				}, 500, function() {
						$('#supmar').css('display','none');
					});
			});
			*/
		});
			
	});
