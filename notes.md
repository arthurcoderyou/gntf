Video recording starts at 56:38

important link: https://gntf.org/2024-golden-chamorro-open/

## CONVO NOTES
Let me know when you want to go over it.

There will be changes and suggestions later from the end users

We need God Admin user (DSI)

GNTF Admin user

General GNTF user

11:38 AM
participant users access with ability to go back and update what event they want to participate in.

general GNTF user / GNTF admin user can also edit participant's profile.

11:39 AM
I think i can also apply that all sir

11:45 AM
I know you can.

Similar to what we are doing with all other program.

11:52 AM
GOD admin (DSI) will be the one to manage user access.

11:53 AM
All user sign up will have standard access which is sign-up as a user, complete the application, select the event, modify the event selected.

Program will based on what is on the application and access a fee.

11:54 AM
All event, schedule, fees imposed and /or collected shall be done / manage by GTNF admin user.

11:55 AM
Need dashboard for GNTF admin user. Any update need to be notified and address as GNTF admin user logged in.

11:55 AM
Noted sir i i will also add all of that sir

11:56 AM
GNTF have a board meeting tonight at 530pm Guam time. You think we can have something for them to comment? Create a admin@gntf.org user as GNTF Admin User.

12:13 PM
admin@gntf.org user will be able to add other gntf user (without the adding of the additional user rights).

12:16 PM
in other word, a user sign up as gntf personnel, admin@gntf.org will need to login to accept that user as gntf staff.

12:17 PM
The only difference between admin@gntf.org and other gntf staff is the ability to accept or provide a user the access to be a gntf staff.

without this acceptance, the user will be just a user / participant user.
## end of CONVO NOTES



Create a tournament entry point for users to enter

Basic login and signup 
    - in order for the user to have a credential signing in and be recognized by the system

Email verification, add gender to the initial signup in order to not let women participate in womens tournament or men going to womens tournament 



After filling up the registration form , the user can see at the bottom an option that will open a new tab that will go to the member registration of gntf
This is also shown and opened if the user is a junior or had selected junior in the form

On teh signing, send a verification code to the email of the user, and also if it needs a parent, enter a user email and check if the code sent to that email is the same. 
Signature after accepting all the notes on the bottom

Players Signature
Parent Signature - U 18
> OTP code 
- email, 
- user_id
- expiration_date 


Prevent male to go to female and vice versa 
Do not let male or femail participate on not their gender


Models 
[user]
- considered as a player
- name 
- email 
- password
- gender
- guardian_email


[tournament]
> Tournament 
- League name
- Status    
    - defines if a tournament is active and can be signed up or not 
- start date 
- end date 
- Director
- Finance 
- Logo 
- tournament status  (  )

     


> Tournament event 
- Events that are connected to the tournament
- tournament_id
- name
- start date    || must be between the tournament start and end date
- end date       || must be between the tournament start and end date and not less event start date 
- registration_deadline 
- status (active,inactive) -> default active

# after clicking an option in the categories, this category and category options will then be copied to that event
Tournament Category
- tournament_event_id
- name
- status (active,inactive) -> default active
- type  || Singles, Doubles, Mixed Doubles 
- allowed_gender || male, female, both

> So the process is on a form, when a user selects an option category, all of the options on that option category will be inherited into the tournament category options. 


Tournament Category Options
- tournament_category_id 
- name
- status


### DEFAULT values  for Category
> OptionCategory 
- can be many 
- name 
- status 
- Example: Age, Skill Level, Division 
    > Options 
    - options of that category when it is selected as part of the tournament event 
    - name 
    - status  
    - Example:  
        - Age : (35+ / 45+ / 55+)
        - Skill Level : (2.0 / 3.0 / 3.5 / 4.0 / 5.0 / Open )
        - Division : (U8 / U10 / U12 / U14 / U16 / U18)  

### end of DEFAULT VALUE for Category


[user_tournament_registration]
> PlayerRegistration 
- user_id
- tournament_id
- tournament_category_id

 

### Notes on February 25 2025 Meeting

Fix the registration list and apply the search queries for all registration data list 

On Guardian email, add guardian name and relationship to the user  

After reading the temrms and conditions, he will be shown the terms and conditions and they will need to check the terms and conditions 

The registration can be deleted because the user can always cancel their game anytime because it must only be a platform for analyzing and tracking and identifying

THe program must be able to track who paid and cant paid
Some players are only paying when they are on the tournament 

Sometimes they changes the events at the last minute, so never lock the registration 

IF they delete or change partner, we must accomodate that change. We query all and refresh to get the latest data. 



On the partner, when selecting the partner, and after registering, there is an auto selection on your partners side that will tell her that you had already selected her as a partner for the website. 
The partner must also be notified that she is being requested to be a partner 
The partner must also be notified that she had declined that partner 

The ideas is to unable them to be requested as a partner for that category if there is already a person that is being requested to .
This is applied to all doubles event


Mixed is something new, this is a condition that if the player is male, then the selection must only show the reverse gender, meaning it must be a female 



On the tournament, add 
[fee_description]   (multiple) denotes the top fee description
- text based 
 
[tournament_description] (multiple) added on the text below the box of the fee descriptions. denotes more information about the tournament
- text based 

[tournament_waiver_text] (multiple) added on the waiver at the bottom the denotes descirptions about the waiver to be check by the user before the submit button can be used 
- text based 
- On the part of Terms and Conditions

- settings
[tournament_fee] (integer) denotes the fee guide for tournament events
- tournament_fee_name 
- first_event_payment
- additional_event_payment 



GNTF Members :
1st Event $20.00 + Additional Events $10.00

Non-GNTF Members:
1st Event $30.00 + Additional Events $10.00

Junior Events:
1st Event $20.00 + Additional Events $10.00