/**
 * Motor Racing League javascript
 * 
 * Copyright 2009 Ian Haycox
 */

/*
 * Replace the current entries with these
 */
function motorracingleague_show_entry(champid, raceid) {
	
	jQuery.ajax({
		type:"POST",
		url: MotorRacingLeagueAjax.blogUrl,
		data:"action=motor_racing_league_show_entries&motorracingleague_comp_id="+champid+"&mrl_race="+raceid,
		success: function(msg){
			jQuery("#motorracingleague_show_results_"+champid).replaceWith(msg);
			jQuery('html, body').animate({scrollTop: jQuery("#motorracingleague_notice").offset().top}, 500);
		},
		error: function(xml, text, error) {
			alert("Error" + xml + text + error);
		}
	});	
		
}

jQuery(document).ready(function($) {

	/*
	 * Clicked show predictions button
	 */
	$("#motorracingleague_show_predictions").click(function() {
			var data = $("#motorracingleague_form").serialize();
		
			$.ajax({
				type:"POST",
				url: MotorRacingLeagueAjax.blogUrl,
				data:"action=motor_racing_league_show_entries&"+data,
				success: function(msg){
					$("#motorracingleague_form").replaceWith(msg);
					$('html, body').animate({scrollTop: $("#motorracingleague_notice").offset().top}, 500);
				},
				error: function(xml, text, error) {
					alert("Error" + xml + text + error);
				}
			});
			
			return false;
		});

	/*
	 * Clicked save prediction button
	 */
	$("#motorracingleague_form").submit(function() {
			var data = $("#motorracingleague_form").serialize();
			var id = -1;
			$.ajax({
				type:"POST",
				url: MotorRacingLeagueAjax.blogUrl,
				data:"action=motor_racing_league_save_entry&"+data,
				dataType:"json",
				success: function(msg){
					id = msg.id;
					$("#motorracingleague_notice").html(msg.message);
					
					//
					// Saved OK - Show predictions for non logged in users.
					//
					if (id != -1 && !msg.logged_in) {
						$.ajax({
							type:"POST",
							url: MotorRacingLeagueAjax.blogUrl,
							data:"action=motor_racing_league_show_entries&"+data,
							success: function(msg){
								$("#motorracingleague_form").replaceWith(msg);
							},
							error: function(xml, text, error) {
								alert("Error" + xml + text + error);
							}
						});
					}
					if (id != -1 && msg.logged_in) {
						$('#motorracingleague-add').val(msg.label);
					}
					
					// Scroll to top of form - For large forms the error message may be off screen.
					$('html, body').animate({scrollTop: $("#motorracingleague_notice").offset().top}, 500);
					
				},
				error: function(xml, text, error) {
					alert("Error" + xml + text + error);
				}
			});
			return false;
		});
	
	/*
	 * Race selection box changed, request predictions for this
	 * event and populate form.
	 */
	$("#motorracingleague_form #mrl_race").change(function() {
			var data = $("#motorracingleague_form").serialize();
			var id = -1;
			$.ajax({
				type:"POST",
				url: MotorRacingLeagueAjax.blogUrl,
				data:"action=motor_racing_league_get_prediction&"+data,
//				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(data){
					
					if (data.msg!="") {
						alert(data.msg);
						return false;
					}
					
					$('#motorracingleague_pole_lap_time').val(data['#motorracingleague_pole_lap_time']);
					$('#motorracingleague_rain').attr('checked', (data['#motorracingleague_rain'] == 1));
					$('#motorracingleague_safety_car').attr('checked', (data['#motorracingleague_safety_car'] ==1));
					$('#motorracingleague_double_up').attr('checked', (data['#motorracingleague_double_up'] == 1));
					$('#motorracingleague_dnf').val(data['#motorracingleague_dnf']);
					
					$('#motorracingleague-add').val(data['label']);
					
					if (data['mrl_disable']) {
						$('.mrl_disable').prop('disabled', true);
					} else {
						$('.mrl_disable').prop('disabled', false);
					}
					
					$('#motorracingleague_notice').html('');  // Clear info messages
					
					for (var p in data.predictions) {
						$(p).val(data.predictions[p]);
					}
				},
				error: function(xml, text, error) {
					alert("Error" + xml + text + error);
				}
			});
			return false;
		});
		
	/*
	 * Statistics race selection box changed, request stats for this
	 * race
	 */
	$("#mrl_stats_race").change(function() {
			var raceid = $("#mrl_stats_race").val();
			var champid = $("#mrl_stats_race").attr('champid');
			var ignoredeadline = $("#mrl_stats_race").attr('ignoredeadline');
			$.ajax({
				type:"POST",
				url: MotorRacingLeagueAjax.blogUrl,
				data:"action=motor_racing_league_get_stats&champid="+champid+"&raceid="+raceid+"&ignoredeadline="+ignoredeadline,
				success: function(msg){
					$('#mrl_stats').html(msg);
				},
				error: function(xml, text, error) {
					alert("Error" + xml + text + error);
				}
			});
			return false;
		});
});


/*
	Author:		Robert Hashemian (http://www.hashemian.com/)
	Modified by:	Munsifali Rashid (http://www.munit.co.uk/)
*/

/*
	Modified by: Ian Haycox
	Countdown timer to next prediction deadline
*/
function motorracingleague_countdown(obj)
{
	this.obj		= obj;
	this.Div		= "clock1";
	this.BackColor		= "white";
	this.ForeColor		= "black";
	this.TargetDate		= "12/31/2020 5:00 AM";
	this.ServerDate		= "12/31/2020 5:00 AM";
	this.DisplayFormat	= "%%D%%d, %%H%%h, %%M%%m, %%S%%s.";
	this.FinishStr      = "Too Late";
	this.CountActive	= true;
	
	this.DisplayStr;

	this.Calcage		= motorracingleague_cd_Calcage;
	this.CountBack		= motorracingleague_cd_CountBack;
	this.Setup		= motorracingleague_cd_Setup;
}

function motorracingleague_cd_Calcage(secs, num1, num2)
{
  s = ((Math.floor(secs/num1))%num2).toString();
  if (s.length < 2) s = "0" + s;
  return (s);
}
function motorracingleague_cd_CountBack(secs)
{
    if (secs < 0) {
	  if (document.getElementById(this.Div) != null) {
		  document.getElementById(this.Div).innerHTML = this.FinishStr;
	  }
	  return;
  }

  this.DisplayStr = this.DisplayFormat.replace(/%%D%%/g,	this.Calcage(secs,86400,100000));
  this.DisplayStr = this.DisplayStr.replace(/%%H%%/g,		this.Calcage(secs,3600,24));
  this.DisplayStr = this.DisplayStr.replace(/%%M%%/g,		this.Calcage(secs,60,60));
  this.DisplayStr = this.DisplayStr.replace(/%%S%%/g,		this.Calcage(secs,1,60));

  if (document.getElementById(this.Div) != null) {
	  document.getElementById(this.Div).innerHTML = this.DisplayStr;
  }
  if (this.CountActive) setTimeout(this.obj +".CountBack(" + (secs-1) + ")", 990);
}
function motorracingleague_cd_Setup()
{
	var dthen	= new Date(this.TargetDate);
  	var dnow	= new Date(this.ServerDate);
	ddiff		= new Date(dthen-dnow);
	gsecs		= Math.floor(ddiff.valueOf()/1000);
	this.CountBack(gsecs);
}
