# EUVBS - Egerton University Vehicle Booking System

The EUVBS is a web app that enables users to book vehicles that are available in the university transport department.
 The system has two types of users, that’s is, the administrator (admin) and normal users (user).
When a user registers an account, they are assigned the default user type ‘user’ in the database.
In order to gain administrative privileges, the user must have access to the database where he/she will change their user type to ‘admin’.
The ‘admin’ and ‘user’ both access they system through the login page. However, they are redirected to different home pages depending on
their user type value.

User:

Normal users who have standard privileges log in into their accounts and can perform the following operations:

1.	Request a booking:
	Here the user gives detailed information on the booking they want to make
2.	Cancel a booking:
	Here the user can cancel on a booking that they have made (confirmed booking) or they intend to make (pending request)
3.	Postpone a booking:
	Here the user can change the date and time of a confirmed booking to a different date and time
4.	View Pending Requests:
	Here the user can view the book requests that they have made that have not yet been confirmed by the administrator.
5.	View Confirmed Requests:
	Here the user can view the book requests that have been confirmed by the administrator

Administrator:

They have administrative privileges and can perform the following operations:

1.	Confirm Bookings:
	Once a user request for a booking, the information is sent to the administrator who then confirms the request solely based on 
	their opinion. The confirmation is done by assigning the respective request a driver and a vehicle identified by its number plate.
	This will then change the availability of both the driver and the vehicle, thus another request cannot be assigned a vehicle or driver
	that is already assigned to another request. The administrator can also view the requests that they have confirmed and once a trip has
	taken place the administrator removes these confirmed requests from the list which makes the vehicle available again for booking.
2.	Add or Remove Vehicle:
	The administrator can add a new vehicle to the system for booking. A detailed information about the vehicle is entered and recorded in 
	the database. However, there must exist at least one driver in the system in order to register a new vehicle. The administrator can also
	remove a vehicle from the system and all its related data will be deleted from the system’s database. 
3.	Mark Vehicle for Maintenance:
	If a vehicle is to undergo a maintenance procedure, it is only natural that it will not be available for booking. This is tackled by the
	administrator’s capability of changing the availability of the vehicle between Y and N.
4.	Add or Remove Drivers:
	The administrator can add a new driver to the system. A detailed information about the driver is entered and recorded in the database. 
	The administrator can also remove a driver from the system and all his/her related data will be deleted from the system’s database. 
	The administrator can also change the availability of the driver from this point.
5.	Remove Users:
	The administrator has the privilege to view all other users of the system. Coupled with that is the ability to remove a user from the 
	system where by the specified user will not be able to access the system again unless they create a new account.
