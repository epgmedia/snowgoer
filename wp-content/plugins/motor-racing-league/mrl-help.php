<?php

function motorracingleague_help() {
	
?>

<div class="wrap">


	<h2>Motor Racing League</h2>

	<p><em>Plugin to manage and present prediction (fantasy) competitions for motor sport events.</em></p>

	<hr />

	<p>
	<strong>Contributors:</strong> <a href="mailto:ian.haycox@gmail.com">Ian Haycox</a><br />

	<strong>Donate link:</strong> <a href="http://www.ianhaycox.com/donate">http://www.ianhaycox.com/donate</a><br />
	<strong>Tags:</strong> prediction, fantasy f1, competition, motor, racing, sport, sport league, sidebar, widget, post<br />
	<strong>Requires at least:</strong> 3.0<br />
	<strong>Tested up to:</strong> 3.5<br />

	<strong>Stable tag:</strong> 1.9.1</p>

	<hr />

<div class="textwidget"><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7899746">
<input type="image" src="https://www.paypal.com/en_US/FR/i/btn/btn_donateCC_LG.gif" style="border:0;" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>

<h3>Usage</h3>

<p>After installation use the Admin 'Motor Racing' settings option to create a championship.</p>

<ul>
<li>Enter season and description, e.g. 2009, F1 World Championship</li>
<li>Number of predictions - The number of places a player must guess. A value of 3 would
be; guess the top three finishers.</li>
<li>PHP Calculator - Leave blank for now.</li>
</ul>

<h4>Creating Drivers and Races</h4>

<p>Click on the Season to define the list of Drivers/Riders that participant in the championship.</p>

<p>Note, when defining a race you must supply the date and time, in YYYY-MM-DD HH:MM format for the entry deadline and
the race start time. Players cannot enter predictions after the deadline. It is safe therefore to leave the entry form
displayed as it will flip over to the next race after the deadline has passed.
Prediction results in the widget only include races after the race start time.</p>

<p>Be aware, of timezone issues. The date and times are entered in server local time, i.e. the timezone where your blog
is hosted. For races in other timezones, make the appropriate adjustment.</p>

<h4>Options</h4>

<ul>
<li>Predict Pole - A player is required to predict the pole sitter</li>

<li>Predict Pole Time - A player must guess the pole sitters qualifying time</li>
<li>Predict Fastest Lap - A player is required to predict the driver who sets the fastest lap in the race</li>
<li>Display Most Laps Led - Display 'Most Laps Led' instead of 'Fastest Lap'.</li>
<li>Predict Rain - A play may predict if this will be a wet or dry race</li>
<li>Predict Safety Car - Will the SC be deployed during the race</li>
<li>Predict DNF - Guess the number of 'Did Not Finish'</li>
<li>Double Up - Choose one race to gain double points.</li>
<li>Cookie Seconds - After a prediction entry has been made a user must wait this many seconds before the
entry form is available again, unless they delete the cookie. Basic prevention to avoid multiple predictions
from a non-logged-in user. Default 500000 seconds (slightly less than a week)  </li>
<li>View predictions before entry - If checked allow users to view other peoples predictions before making their own. </li>
<li>Predictors must be logged in - Option to only allow logged in users to predict. Note - This option allows users to modify their predictions up until the race entry deadline. Logged in users must have the 'predict'
capability as part of their Wordpress role. By default all roles have the 'predict' capability.</li>
</ul>

<h4>Scoring - Points Calculations</h4>

<p>Points are awarding to players' predictions depending on the settings made in the Championship
Scoring tab. Most settings should be self-explanatory.</p>

<ul>
<li><p>Pole Lap Time - Assign points if a player guesses within a percentage of the actual time. The 'Add more...' button
allows the addition of extra entries to create a sliding scale of guesses. For example, within 0.25% = 10 points, within 0.5%
= 5 points. Note - 0% is an exact match to the millisecond.</p></li>
<li><p>Use Race Points - When "Use Race Points" is checked, players are awarded points from the race result for each
prediction that matches. For example, player predicts Driver1 in second place. If Driver1 finishes fifth, then the
player gains points for the fifth place finish.</p></li>

<li><p>Custom Scoring - An example PHP module is supplied to calculate players prediction points. Points are awarded very simply
giving each player 10 points for correctly guessing the Pole Sitter, Pole Lap Time, Fastest Lap/Laps Led and 10 points each for correctly
guessing the finishing position.</p></li>
</ul>

<p>The example module, <code>motorracingleaguepoints.php</code>, can be used as a basis for your own scoring system.
To use your own, copy the default module and place the file in the new same directory as the
default module. Edit as desired and specify the filename as the Calculator in the championship.
Comments in the example module should be self explanatory.</p>

<p>If you can't find a friendly PHP programmer then for a small donation I can create a points
module for you.</p>

<p>DO NOT edit the default module, it may be replaced on upgrades.</p>

<p>An alternative module, f1fanatic.co.uk.php, is another example. However this relies on the championship
being configured with four predictions per race. The pole sitter and top three finishers.</p>

<h4>Race Completion</h4>

<p>Once a specified race has finished, use the Race Result option to enter the finishing positions.</p>

<p>If you have checked the 'Use Race Points' option in Scoring, then enter points for each finishing position, otherwise
leave at zero.</p>

<p>The prediction points are updated according to the Scoring scheme chosen.</p>

<p>Users predictions can be viewed via the Predictions option.</p>

<h4>Settings</h4>

<ul>
<li><p>Display promotion link - Add a link to my homepage if checked in the themes' footer.</p></li>

<li><p>Max statistical positions - Limit the number of positions when showing statistics. The suggested value is 3 to show only the podium positions.
Large numbers (usually greater than 6) can result in very slow database queries. Use 0 to set as the same as the number of predictions.</p></li>
<li><p>Allow the collection of users' email addresses for those that check the opt-in checkbox.</p></li>

<li><p>Send a confirmation email of a players prediction - Enter a subject and a proforma email body. I don't recommend setting this
unless you require users to be logged in, otherwise emails could be send to any email address.</p></li>

<li><p>Send a reminder email to alert users of an impending race - Enter the number of hours before the entry deadline to send the remininder, a subject and a proforma email body.</p>
<p>For the first race of the season a reminder is sent to all registered users.</p>
<p>For subsequent races, we send the reminders to all users who submitted predictions for any race in the current championship.</p>
<p>In both cases reminders are not send if the users has already predicted the current race, or a user has clicked the opt-out link.</p>

</li>


</ul>

<h4>Shortcodes</h4>

<p>You can display the entry form with the following code in a post</p>

<pre><code>[motorracingleague entry=x]
</code></pre>

<p>Replace x with the respective Championship ID to display. The entry form will display a countdown to the next
race deadline. Once expired then the race is removed from the dropdown options and the next race presented.
If the option to allow only logged in users to predict is enabled, the entry form does not present the player name and
email address fields. These are taken from their profile.</p>

<p>Display a table of the latest prediction standings with the following code in a post</p>

<pre><code>[motorracingleague results=x]
</code></pre>

<p>Substitute x with the respective of the Championship ID to display. After each race is complete the results for all
previous races are shown with the points scored for each user. The optional parameter cols=n can be used to
display player names on the right hand side of the table when the table width is wider than the display
and a scroll bar is used to scroll horizontally. For example, cols=10 will add the player name on the
right hand side once the number of race results exceeds 10.</p>

<p>The optional parameter `used_doubleups=1` will append an additional table to the results listing the players who
have used thier Double Up option during the season. The race and extra points awarded for using the double up is also shown.
</p>

<p>Display a table with details for every players predictions for one race with the following</p>

<pre><code>[motorracingleague race=x limit=n full=m]
</code></pre>

<p>Substitute x with the Race ID to be displayed. After the results for the race have been entered
this shows all the players predictions and score for the selected race. The parameters limit and
full are optional.</p>

<p>limit=n  Where n is the maximum number of rows to display
full=m Where m = 1, show the players predictions, m = 0, just show points gained for the race.</p>

<p>Without limit and full, all results are shown with each prediction.</p>



<p>Display the currently logged in users' predictions for all races in this championship</p>

<pre><code>[motorracingleague predictions=x]
</code></pre>

<p>Substitute x with the respective Championship ID to display.</p>


<p>Display a short summary of prediction statistics. This is includes average pole lap time, most common predictions etc.
Prediction statistics are only shown for the races AFTER the prediction deadline has expired.</p>

<pre><code>[motorracingleague stats=x ignoredeadline=0]
</code></pre>

<p>Substitute x with the respective Championship ID to display.</p>
<p>Prediction statistics are only shown once the entry deadline has passed.  To show statistics before the entry
deadline has passed use ignoredeadline=1 This may give an advantage to some players as they will be able
to see the most common predictions before making thier own.</p>



<p>All shortcodes also take an optional style parameter to apply a CSS style to the table. For example,
    [motorracingleague race=x style="width:50%"]
will make the race results table narrower.</p>

<h4>Widget</h4>

<p>Drag and drop the widget to a sidebar and configure. Multiple instances of the widget, each configured separately, may be
placed on a sidebar.</p>

<p>If a championship id is entered then only the summary results for that championship are displayed.
If this is left blank, then all championships are displayed in the widget.</p>

<p>Leave race selection as 'All Races' to display summary results - same output as <code>[motorracingleague results=x]</code> Choosing
a specific race outputs data similar to <code>[motorracingleague race=x]</code></p>

<p>If Show Predictions for Race, is checked, it displays the top n players scores and their predictions for the selected race.</p>

<p>If not blank the URL option adds a link to the full results page using the title below as the link text.</p>

</div>

<?php 	
	
}

?>