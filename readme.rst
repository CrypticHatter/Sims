###################
Student Information management system
###################

This is a school information management system application that i was created for my project using codeigniter framework. 
It comprises following modules.

1. Student, Teacher registration
2. Classroom management
3. Subjects and timetable management
4. Student attendance tracker
5. Student payment tracker
6. School event and annocements
7. Examination schedule and result management
8. Report generator
9. User profile management
10. Backup and System configuration

*******************
Application details
*******************
I was used "Admin LTE" Bootstrap HTML theme as the design of my application. (https://adminlte.io/themes/AdminLTE/index2.html)
"theme.php" view file contain common layout design of the application, each page contents will be injected when calling controller class 
functions. HTML layouts of admin side was located inside "Admin" directory inside view file. Most of these view files are modified 
by me to match with application requiremtents. 

I was used a common model class called "My_model" for common CRUD functions of the application such as create, Update, file upload etc.
You can find it inside "core" directory. All model classes are extended from that common model. All Controllers and Model Class files 
are written by myself.


*******************
Plugins and libraries
*******************
I have used "PHPExcel", "CSV reader" libraries to read, store and generate excel and csv files related data.
also jQuery plugins like chartjs, fullcalendar, iCheck, Morries chart etc. were used as requirements of application.


*******************
Helper classes
*******************

There were two helper classes written by me, one for manage emails and other one for common functions of app like format date, duration, show validation error or success alerts etc. 



