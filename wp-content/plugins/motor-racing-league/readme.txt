=== Motor Racing League ===
Contributors: ianhaycox, Ian Haycox
Donate link: http://www.ianhaycox.com/donate.php
Tags: prediction, fantasy f1, competition, motor, racing, sport, sport league, sidebar, widget, post
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.9.5

Plugin to manage and present prediction (fantasy) competitions for motor sport events. 

== Description ==

This Plugin is designed to manage motor sport races and championships and allow users to predict the outcome
of the races. Points are awarded based on users' predictions and the actual finishing order of the race.

Most motor sport competition types are supported. Basically any event that involves qualifying, then a race
with a finishing order. For example, Formula One, NASCAR, Moto GP, even possibly cycle races. 

These types of prediction games are often referred to as Fantasy competitions.

If you do download this plugin please come back and rate it. For any rating less than 5 stars
I would love to hear your feedback to help improve the plugin. Usability issues, bugs, enhancements
and any other comments welcome to make this plugin better. [Contact](http://www.ianhaycox.com/contact)

**Features**

* easy adding of championships, races and drivers/riders
* entry form for users to make predictions for races on defined championships
* sidebar widget to display prediction standings
* multiple championships supported
* pluggable modules to support multiple custom points calculations
* countdown timer to next prediction deadline
* option to limit only logged in users
* display statistics for prediction frequencies
* email prediction confirmations
* email prediction reminders

**New Features**

Version 1.9.5

* Fixed bug with scoring when 'Use Race Points' was checked.  Only award points if the predicted and actual finishing positions match.

Version 1.9.4

* New option `[motorracingleague results=x used_doubleups=1]` displays an extra table of players who have doubled up previously in the season.

Version 1.9.2

* Added ignoredeadline option to statistics shortcode to display prediction statistics before the entry deadline has passed.

Version 1.8

* Can predict Rain, Safety Car, DNF and Double Up points for one race. Contribution by [gpwizard.co.uk](http://www.gpwizard.co.uk).
* New optional Qualifying Deadline to allow changes to race predictions after qualifying but before race start.
* Hovering over race results and predictions shows a tooltip with the points breakdown for each race or prediction.

Version 1.7

* Send reminder emails to users who have not predicted. Contribution by [F1Fanatic.co.uk](http://www.f1fanatic.co.uk).

Version 1.3

* Optionally send email confirmation for a players' predictions
* New shortcode to display the logged in players predictions

Version 1.2

* Truncate long player names on display to prevent very wide tables
* Scroll browser window to highlight invalid input
* Mailing list opt-in feature for visitor predictions
* New shortcode option to display prediction summary statistics.

Version 1.1 includes the following:-

* option to predict pole lap time
* option to predict fastest lap (or most laps led) driver
* multiple configurable widgets to display race or championship scores
* option to prevent loading of Javascript and CSS for pages and posts without a shortcode
* logged in users can modify their predictions
* custom scoring assignments without the need for a PHP module 

** Shortcode changes **

The shortcodes `[motorracingleague_x]` and `[motorracingleague_results_x]` have been replaced by the shortcodes
`[motorracingleague entry=x]` and `[motorracingleague results=x]` respectively.

A new shortcode `[motorracingleague race=x]` has also been introduced for specific race results.

The old shortcode format will not work with this version. Please edit any old posts or pages to use the new
format. See the usage instructions for more details on shortcode syntax.


**Translations**

Also available in Spanish. - Thanks to Sammy.
Portuguese. Thanks to Willian.
and Polish. Thanks piotreklobcio

Other translations, help needed here.

**Statistics**

An additional plugin is available to display comprehensive race results for most forms of motor sport.
For more information see [Motor Sport Results](http://www.ianhaycox.com/f1stats)
Formula One race data from 1950 until 2012 is available for this plugin. 

== Upgrade Notice ==

In order to cater for new features the database schema has been changed. This should be done automatically
after the plugin is deactivated and re-activated. Existing championship definitions will have been migrated.
You should check prior championships to verify correctness.

= Shortcode changes =

The shortcodes `[motorracingleague_x]` and `[motorracingleague_results_x]` have been replaced by the shortcodes
`[motorracingleague entry=x]` and `[motorracingleague results=x]` respectively.

A new shortcode `[motorracingleague race=x]` has also been introduced for specific race results.

The old shortcode format will not work with this version. Please edit any old posts or pages to use the new
format. See the usage instructions for more details on shortcode syntax.

= Custom PHP calculator =

If you use a custom scoring PHP module please see the motorracingleaguepoints.php module for changes.


== Installation ==

To install the plugin complete the following steps

1. Unzip the zip-file and upload the content to your Wordpress Plugin directory. Usually `/wp-content/plugins`
2. Activate the plugin via the Admin plugin page.
3. Configure Championships, Drivers, Races etc via the Admin page.

For more details on configuration see [Other Notes](http://wordpress.org/extend/plugins/motor-racing-league/other_notes/).

== Frequently Asked Questions ==
= Can I change the way points are calculated? =

Yes, see the 'Points Calculations' section in [Other Notes](http://wordpress.org/extend/plugins/motor-racing-league/other_notes/).

= I have the message 'Clock Error' - what should I do ? =
If you are seeing this message then the Javascript to display the countdown clock is not being executed correctly.

This is usually caused by a Javascript error in other plugins or themes. Use your browser to view any errors reported in the console and
try to identify the cause of the error.  Often deactivating the plugin reporting the error will restore the countdown clock. 

= Can users guess a fastest lap/pole time? =
Yes, see the options available when creating a championship.

= Do users have to be logged in to play? =
No, any visitor can make a prediction. There is, however, an option that ensures only logged in users can predict.

= Can users see other peoples predictions =
Yes they can. There is an option to prevent viewing other peoples predictions
before making your own.

= Why do my posts have [motorracingleague_1] in them? =
The shortcode format has changed. Use [motorracingleague entry=1]. See Usage instructions for more details.

== Screenshots ==
1. Prediction entry form
2. Results display and sidebar widget
3. Admin race results
4. Admin prediction results
5. Championship definition
6. Drivers Admin
7. Races Admin
8. Options Admin
9. Scoring Confirguration
10. Summary of users predictions
11. Statistics for a race


== Usage ==

After installation use the Admin 'Motor Racing' settings option to create a championship.

* Enter season and description, e.g. 2009, F1 World Championship
* Number of predictions - The number of places a player must guess. A value of 3 would
be; guess the top three finishers.
* PHP Calculator - Leave blank for now.

Click on the Season to define the list of Drivers/Riders that participant in the championship.

Note, when defining a race you must supply the date and time, in YYYY-MM-DD HH:MM format for the entry deadline and
the race start time. Players cannot enter predictions after the deadline. It is safe therefore to leave the entry form
displayed as it will flip over to the next race after the deadline has passed.
Prediction results in the widget only include races after the race start time.

Be aware, of timezone issues. The date and times are entered in server local time, i.e. the timezone where your blog
is hosted. For races in other timezones, make the appropriate adjustment.


= Options =

* Predict Pole - A player is required to predict the pole sitter
* Predict Pole Time - A player must guess the pole sitters qualifying time
* Predict Fastest Lap - A player is required to predict the driver who sets the fastest lap in the race
* Display Most Laps Led - Display 'Most Laps Led' instead of 'Fastest Lap'.
* Predict Rain - A play may predict if this will be a wet or dry race
* Predict Safety Car - Will the SC be deployed during the race
* Predict DNF - Guess the number of 'Did Not Finish'
* Double Up - Choose one race to gain double points.
* Cookie Seconds - After a prediction entry has been made a user must wait this many seconds before the
entry form is available again, unless they delete the cookie. Basic prevention to avoid multiple predictions
from a non-logged-in user. Default 500000 seconds (approx 6 days)  
* View predictions before entry - If checked allow users to view other peoples predictions before making their own. 
* Predictors must be logged in - Option to only allow logged in users to predict. Logged in users must have the 'predict'
capability as part of their Wordpress role. By default all roles have the 'predict' capability.

= Points Calculations =

Points are awarding to players' predictions depending on the settings made in the Championship
Scoring tab. Most settings should be self-explanatory.

* Pole Lap Time - Assign points if a player guesses within a percentage of the actual time. The 'Add more...' button
allows the addition of extra entries to create a sliding scale of guesses. For example, within 0.25% = 10 points, within 0.5%
= 5 points. Note - 0% is an exact match to the millisecond.

* Use Race Points - When "Use Race Points" is checked, players are awarded points from the race result for each
prediction that matches. For example, player predicts Driver1 in second place. If Driver1 finishes fifth, then the
player gains points for the fifth place finish.

* Custom Scoring - An example PHP module is supplied to calculate players prediction points. Points are awarded very simply
giving each player 10 points for correctly guessing the Pole Sitter, Pole Lap Time, Fastest Lap/Laps Led and 10 points each for correctly
guessing the finishing position.

The example module, `motorracingleaguepoints.php`, can be used as a basis for your own scoring system.
To use your own, copy the default module and place the file in the new same directory as the
default module. Edit as desired and specify the filename as the Calculator in the championship.
Comments in the example module should be self explanatory.

If you can't find a friendly PHP programmer then for a small donation I can create a points
module for you.

DO NOT edit the default module, it may be replaced on upgrades.

An alternative module, f1fanatic.co.uk.php, is another example. However this relies on the championship
being configured with four predictions per race. The pole sitter and top three finishers. 

= Race Completion =

Once a specified race has finished, use the Race Result option to enter the finishing positions.

If you have checked the 'Use Race Points' option in Scoring, then enter points for each finishing position, otherwise
leave at zero.

The prediction points are updated according to the Scoring scheme chosen.

Users predictions can be viewed via the Predictions option.

= Settings =

* Display promotion link - Add a link to my homepage if checked in the themes' footer.

* Max statistical positions - Limit the number of positions when showing statistics. The suggested value is 3 to show only
the podium positions. Large numbers (usually greater than 6) can result
in very slow database queries. Use 0 to set as the same as the number of predictions.

* Allow the collection of users' email addresses for those that check the opt-in checkbox.

* Send a confirmation email of a players prediction - Enter a subject and a proforma email body. I don't recommend setting this
unless you require users to be logged in, otherwise emails could be send to any email address.

* Send a reminder email to alert users of an impending race - Enter the number of hours before the entry deadline to send the remininder, a subject and a proforma email body.
* For the first race of the season a reminder is sent to all registered users
* For subsequent races, we send the reminders to all users who submitted predictions for any race in the current championship.
* In both cases reminders are not send if the users has already predicted the current race, or a user has clicked the opt-out link.



= Shortcodes =
You can display the entry form with the following code in a post

`[motorracingleague entry=x]`

Replace x with the respective Championship ID to display. The entry form will display a countdown to the next
race deadline. Once expired then the race is removed from the dropdown options and the next race presented.
If the option to allow only logged in users to predict is enabled, the entry form does not present the player name and
email address fields. These are taken from their profile.  

Display a table of the latest prediction standings with the following code in a post

`[motorracingleague results=x]`

Substitute x with the respective Championship ID to display. After each race is complete the results for all
previous races are shown with the points scored for each user. The optional parameter cols=n can be used to
display player names on the right hand side of the table when the table width is wider than the display
and a scroll bar is used to scroll horizontally. For example, cols=10 will add the player name on the
right hand side once the number of race results exceeds 10.

The optional parameter `used_doubleups=1` will append an additional table to the results listing the players who
have used thier Double Up option during the season. The race and extra points awarded for using the double up is also shown.

Display a table with details for every players predictions for one race with the following

`[motorracingleague race=x limit=n full=m]`
 
Substitute x with the Race ID to be displayed. After the results for the race have been entered
this shows all the players predictions and score for the selected race. The parameters limit and
full are optional.

limit=n  Where n is the maximum number of rows to display - 0 is no limit
full=m Where m = 1, show the players predictions, m = 0, just show points gained for the race.

Without limit and full, all results are shown with each prediction.

Display the currently logged in users' predictions for all races in this championship

`[motorracingleague predictions=x]`

Substitute x with the respective Championship ID to display.


Display a short summary of prediction statistics. This is includes average pole lap time, most common predictions etc.
Prediction statistics are only shown for the races AFTER the prediction deadline has expired.

`[motorracingleague stats=x ignoredeadline=0]`

Substitute x with the respective Championship ID to display.
Prediction statistics are only shown once the entry deadline has passed.  To show statistics before the entry
deadline has passed use ignoredeadline=1 This may give an advantage to some players as they will be able
to see the most common predictions before making thier own.

All shortcodes also take an optional style parameter to apply a CSS style to the table. For example,
`[motorracingleague race=x style="width:50%"]`
will make the race results table narrower.

= Widget =

Drag and drop the widget to a sidebar and configure. Multiple instances of the widget, each configured separately, may be
placed on a sidebar.

If a championship id is entered then only the summary results for that championship are displayed.
If this is left blank, then all championships are displayed in the widget.

Leave race selection as 'All Races' to display summary results - same output as `[motorracingleague results=x]` Choosing
a specific race outputs data similar to `[motorracingleague race=x]`

If Show Predictions for Race, is checked, it displays the top n players scores and their predictions for the selected race.

If not blank the URL option adds a link to the full results page using the title below as the link text.

== Changelog ==

= 1.9.4 - 13th Sep 2013 =
* Bug fix for tooltips showing incorrect driver on `[motorracingleague results=x]`
* Performance improvements for `[motorracingleague results=x]`
* New option `[motorracingleague results=x used_doubleups=1]` displays an extra table of players who have doubled up previously in the season.

= 1.9.3 - 3rd Aug 2013 =
* Updates for WordPress V3.6

= 1.9.2 - 12th Jul 2013 =
* Added ignoredeadline option to statistics shortcode to display prediction statistics before the entry deadline has passed.
* Bug fix to honour 'Double Up' setting between Qualifying and Race prediction deadlines.

= 1.9.1 - 8th Apr 2013 =
* Fix upgrade procedure now that Wordpress no longer deactivates/reactivates on upgrade.
* Change default option to 'Must be logged-in', 'Can not see predictions', 'Max Stats' = 3
* Correct points breakdown tooltips
* Reduce memory usage on front-end
* Removed 'Conditional CSS/JS' option as it didn't work in some cases !
		
= 1.9 - 19th Mar 2013 =
* Handle 'Show Predictions' button better if no predictions.
* Improved robustness of email reminders.
* Bug fix for qualifying deadline for last race of season.
		
= 1.8 - 12th Mar 2013 =
* Allows predictions for Rain, Safety Car, DNF
* Allow users to Double Up points for one race
* Minor bug fixes and usability improvements

= 1.7 - 8th Mar 2013 =
* Send email reminders to users who have not predicted

= 1.6 - 18th Feb 2013 =
* Do not save late entries - i.e. those submitted after the deadline
* Order rankings from `[motorracingleague results=x]` by Total Points, Best Previous Round, Earliest Prediction
* Update jQuery stylesheet
* Display actual date (not local date/time) of a prediction in the admin screens

= 1.5.2 - 12th Dec 2012 =
* Bug fix for missing tabs in Wordpress V3.5
		
= 1.5.1 - 15th Nov 2012 =
* Bug fix for some themes not showing the countdown clock.

= 1.5 - 10th Mar 2012 =
* Bug fix for [motorracingleague predictions=x] not honouring the championship ID
* Added total points to logged-in users' predictions
* Updates for WP 3.* to remove PHP notices
* Display message before saving if a user must be logged in to predict

= 1.4   - 20th Mar 2011 =
* Updates for Wordpress Multi-site installations
* Experimental setting to show the users display_name from their profile instead of login_name.  NOTE - If a user changes their display name mid season the points may not tally correctly.  Still under development.
		
= 1.3   - 23th Feb 2011 =
* Correct minor bug loading admin stylesheet
* Fix minor bug with checkboxes and Google Chrome browser
* Allow Opt-in mailing list function for all types of users.
* Optionally send a confirmation email of a players' prediction
* Drop temporary tables after points calculations
* Added shortcode [motorracingleague predictions=n] to list a logged-in players predictions
        
= 1.2.1 - 29th Apr 2010 =
* Truncate the display of very long user names to prevent wide tables.
* Added mailing list opt-in feature for visitor predictions
* New shortcode to display summary predictions statistics.
* Scroll browser window to highlight error message for invalid input.

= 1.1.2 - 6th Feb 2010 =
* Fix bug with non privileged AJAX requests failing

= 1.1.1 - 4th Feb 2010 =
* Prevent the display of other peoples predictions for logged in users.

= 1.1 - 18th Jan 2010 =
* Administration screens tidied up and minor bug fixes
* Logged in users can now change predictions up until the race deadline.
* Scoring tab for a championship to assign points depending on finishing positions.
* Make the prediction of pole position optional
* Allow the prediction of fastest lap (or most laps led) driver
* Allow the prediction of pole lap time
* Changes to shortcode syntax to ease future enhancements. See [Upgrade Notice](http://wordpress.org/extend/plugins/motor-racing-league/upgrade_notice/).
* Allow multiple instances for results Widget. You can now add a widget for each championship. Requires Wordpress 2.8+
* Moved some settings from global to championship related.
* Added scrollbar to users' results table for narrow display columns.
* Added option to prevent loading of Javascript and CSS unless post has an [motorracingleague] shortcode present.
* Portuguese translation - Thanks Willian

= 1.0.7 - 17th Nov 2009 =
* Fix class error bug
* Added Copy Drivers option

= 1.0.6 - 9th Oct 2009 =
* Correct a couple of spelling mistakes
* Added column to results and widget display to show a players ranking
* Correct bad path location for language translation files.
* Stylesheet change to right-justify points columns for a neater display.
* Spanish translation added - Thanks Sammy
* Bug fix - Correct display problem if two predictions have equal timestamps
* Bug fix - Check players email address against previous entry to prevent new users 'hi-jacking' old player names.
* Fixed Javascript clash with prototype and jquery libraries. Should also fix problems with Atahualpa Theme

= 1.0.5 - 1st Sep 2009 =
* Add option to allow users to view other peoples predictions	before making their own.
* Administrators can alter players predictions, e.g. due to user data entry errors.
* Bug fix - Recalculating results trashed entry timestamp preventing further recalculations
* because the entry time had now passed the race deadline
* Option to ensure users must be logged in before predicting

= 1.0.4 - 25th Aug 2009 =
* Updates for compatibility with MySQL 4.0
* Alter database schema to prevent duplicate drivers
* Add option to display promotion link to author homepage
* Added Javascript countdown timer to next entry deadline

= 1.0.3 - 17th Aug 2009 =
* Allow some changes to championship settings
* Added missing screen shots
* Added simple import of old race results.
* BUG FIX - Handle missing championships better.

= 1.0.2 - 16th Aug 2009 =
* Bug fix activation/deactivation problem. Correct bad directory path.

= 1.0 - 16th Aug 2009 =
* Initial Version

[ChangeLog](http://svn.wp-plugins.org/motor-racing-league/trunk/changelog.txt)
