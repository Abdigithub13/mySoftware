#include <iostream>
#include<conio.h>
#include <string>
using namespace std;
struct Car
{
	string carname;
	string carmodel;
	string carcolor;
	int yearofpublished;
	int car_id, rentalday;
	float priceperday;
	int day;
	bool rented;
	Car* next;
	Car* prev;
	Car(string carname, string carmodel, string carcolor, int yearofpublished, float priceperday, int car_id) : carname(carname), carmodel(carmodel),
			carcolor(carcolor), yearofpublished(yearofpublished), priceperday(priceperday), car_id(car_id), rented(false), next(NULL), prev(NULL) {}
};
struct CarLinkedList
{
	Car* head;
	Car* tail;
	CarLinkedList() : head(NULL), tail(NULL) {}
	void addCarAtBeginning(string carname, string carmodel, string carcolor, int yearofpublished, float priceperday, int car_id)
	{
		Car* newCar = new Car(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
		if (head==NULL)
		{
			head = tail = newCar;
		}
		else
		{
			newCar->next = head;
			head->prev = newCar;
			head = newCar;
		}
		cout << "vehicle added successfully \n";
	}
	void addCarAtEnd(string carname, string carmodel, string carcolor, int yearofpublished, float priceperday, int car_id)
	{
		Car* newCar = new Car(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
		if (head==NULL)
		{
			head = tail = newCar;
		}
		else
		{
			tail->next = newCar;
			newCar->prev = tail;
			tail = newCar;
		}
		cout << "vehicle added successfully \n";
	}
	void addCarAtPosition(string carname, string carmodel, string carcolor, int yearofpublished, float priceperday, int car_id, int position)
	{
		Car* newCar = new Car(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
		if (position <= 0)
		{
			addCarAtBeginning(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
		}
		else
		{
			Car* current = head;
			int count = 1;
			while (current && count < position)
			{
				current = current->next;
				count++;
			}
			if (current)
			{
				newCar->next = current->next;
				newCar->prev = current;
				if (current->next)
				{
					current->next->prev = newCar;
				}
				else
				{
					tail = newCar;
				}
				current->next = newCar;
				cout << "vehicle added successfully \n";
				
			}
			else
			{
				cout << "Invalid position\n";
			}
			
		}
	}
	void delete_first()
	{
		if (head == NULL)
			cout << "Empty linked list";
		else
		{
			struct Car *p;
			p = head;
			head = head->next;
			delete p;
			cout << "car deleted succesfully from first \n";
		}
	}
	void delete_last()
	{
		struct Car *p;
		if (head == NULL)
			cout << "Empty Linked List";
		else if (head->next == NULL)
		{
			p = head;
			head = NULL;
			delete p;
			cout << "car deleted succesfully from last\n";
		}
		else
		{
			struct Car *p, *p2;
			p = head;
			while (p->next != NULL)
			{
				p2 = p;
				p = p->next;
			}
			p2->next = NULL;
			delete p;
			cout << "car deleted succesfully from last\n";
		}
	}
	void delete_pos()
	{
		int pos, i, counter = 0;
		if (head == NULL)
		{
			cout << "List is empty" << endl;
			return;
		}
		cout << "Enter the position of value to be deleted: ";
		cin >> pos;
		struct Car *s, *ptr;
		s = head;
		if (pos == 1)
		{
			head = s->next;
		}
		else
		{
			while (s != NULL)
			{
				s = s->next;
				counter++;
			}
			if (pos > 0 && pos <= counter)
			{
				s = head;
				for (i = 1;i < pos;i++)
				{
					ptr = s;
					s = s->next;
				}
				ptr->next = s->next;
			}
			else
			{
				cout << "Position out of range" << endl;
			}
			free(s);
			cout << "Element Deleted" << endl;
		}
	}
	void listAllCars() const
	{
		Car* current = head;
		if (head == NULL)
		{
			cout << "No Car is available\n";
		}
		int pos = 1;
		cout << "=============================== list available ========================================================" << endl;
		while (current)
		{
			cout << pos << ". car name : " << current->carname << " car model: " << current->carmodel << " car color: "
			<< current->carcolor << " yaer of published : " << current->yearofpublished <<
			" price per day :" << current->priceperday << " car id: " << current->car_id << " This car Is:" << (current->rented ? "  rented" : " not rented") << endl;
			current = current->next;
			pos++;
		}
		cout << "---------------------------------------------------------------------------------------------------------" << endl;
	}
	void rentCar(string customername, int phonenum, string address, int age, int carid, float tax, int rentalday)
	{
		Car* current = head;
		int count = 1;
		while (current && count < carid)
		{
			current = current->next;
			count++;
		}
		if (current && !current->rented)
		{
			current->rented = true;
			cout << "Car rented successfully.\n";
		}
		else
		{
			cout << "Invalid position or car already rented.\n";
		}
	}
	void update()
	{
		Car *temp = head;
		int pos, id, price, year;
		string name, model, color;
		hhh:
		cout << "enter position :";
		cin >> pos;
	    if(pos>check()||pos<=0){
		cout<<"invalid position"<<endl;
		goto hhh;
		}
		if (head == NULL)
		{
			cout << "no available car to update" << endl;
		}
		else
		{
			if (pos > 0 && pos <= check())
			{
				for (int i = 1;i < pos;i++)
				{
					temp = temp->next;
				}
				cout << "update carname :";
				cin >> name;
				temp->carname = name;
				cout << "update model :";
				cin >> model;
				temp->carmodel = model;
				cout << "update color :";
				cin >> color;
				temp->carcolor = color;
				cout << "update price :";
				cin >> price;
				temp->priceperday = price;
gggg:
				cout << "update yearofpublished :";
				cin >> year;
				if (year > 2024 || year < 2000)
				{
					cout << "enter valid year between 2000 and 2023" << endl;
					goto gggg;
				}
				temp->yearofpublished = year;
				cout << "update id :";
				cin >> id;
				temp->car_id = id;
				cout << "successfully updated" << endl;
			}
		}
	}
	void generateReports() const
	{
		Car* current = head;
		int u = 1;
		float tax = 23.7;
		cout << "==============================================Generate Report===============================================" << endl;
		while (current)
		{
			if (current->rented)
			{
				cout << u << ". car name : " << current->carname << "car model: " << current->carmodel << " car color :  " << current->carcolor <<
				" yaer of published : " << current->yearofpublished <<
				"pricep per day :" << current->priceperday << "car id: " << current->car_id << " total cost=" << "  Rented:" << (current->rented ? "  YES" : "   NO") << endl;
				cout << "revenues of car is 23.7 ETB" << endl;
				cout << "Total cost= " << current->priceperday + tax << endl;
			}
			current = current->next;
		}
		cout << "----------------------------------------------------------------------------------------------------------------" << endl;
	}
	void returnCar(int car_id)
	{
		Car* current = head;
		while (current)
		{
			if (current->car_id == car_id)
			{
				current->rented = false;
				cout << "Car returned successfully.\n";
				return;
			}
			current = current->next;
		}
		cout << "Car not found.\n";
	}
	~CarLinkedList()
	{
		Car* current = head;
		while (current)
		{
			Car* next = current->next;
			delete current;
			current = next;
		}
	}
	int check()
	{
		Car *temp = head;
		int count = 0;
		while (temp != NULL)
		{
			temp = temp->next;
			count++;
		}
		return count;
	}
	
};

int main()
{
	CarLinkedList carList;
	Car *ttt;
	int choice;
	int cho;
	do
	{
	
	
back:
		cout << "=======================WELCOME TO CAR RENTAL MANAGEMENT SYSTEM===========================" << endl;
		cout << "please select an option\n";
		cout << "1. ADMIN MENU: \n";
		cout << "2. CUSTOMER MENU:  ";
		cin >> cho;
		cout << endl;
		cout << "----------------------------------\n";
		switch (cho)
		{
		
		case 1:
		{
		      string ownerpassword = "aaa";
pass:
					string password;
					cout << "enter owner password \n";
					cin >> password;
					if (password != ownerpassword)
					{
						cout << "in correct password you are not auothorised to perforn this action\n";
						goto pass;
						break;
						}
		
		
			while (1)
			{
				cout << "1. Add car\n";
				cout << "2. List all cars\n";
				cout << "3. Generate reports\n";
				cout << "4. update a car\n";
				cout << "5. delete the car\n";
				cout << "9. to back main function\n";
				cout << "0. Exit\n";
				cout << "----------------------------------\n";
				cout << "Enter your choice: ";
				cin >> choice;
				system("cls");
				cout << "-------------------------------------------------------------------------------------------" << endl;
				switch (choice)
				{
				case 1:
				{
					
					string carname, carmodel, carcolor;
					int yearofpublished, car_id;
					float priceperday;
					int addChoice;
					cout << "================== position to insert========================" << endl;
					cout << "1. Add at the beginning\n";
					cout << "2. Add at the end\n";
					cout << "3. Add at a specific position\n";
					cout << "Enter your choice: ";
choicee:
					cin >> addChoice;
					if (addChoice > 3 || addChoice < 0)
					{
						cout << "error choice\n";
						goto choicee;
						break;
					}
					cout << "---------------------------------------------------------------" << endl;
					cout << "Enter car name: ";
					cin >> carname;
					cout << "Enter car model: ";
					cin >> carmodel;
					cout << "Enter car color: ";
					cin >> carcolor;
loop:
					cout << "Enter car yearpofpublished: ";
					cin >> yearofpublished;
					if (yearofpublished > 2024 || yearofpublished < 2000)
					{
						cout << "enter valid year between 2000 and 2023" << endl;
						goto loop;
						break;
					}
cost:
					cout << "Enter car price per day: ";
					cin >> priceperday;
					if (priceperday < 500 || priceperday > 4000)
					{
						cout << "invalid cost enter more than 500 birr" << endl;
						goto cost;
						break;
					}
					cout << "Enter car id: ";
					cin >> car_id;
					switch (addChoice)
					{
					case 1:
						carList.addCarAtBeginning(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
						break;
					case 2:
						carList.addCarAtEnd(carname, carmodel, carcolor, yearofpublished, priceperday, car_id);
						break;
					case 3:
					{
						int position;
poss:
						cout << "Enter position: ";
						cin >> position;
						if (position > carList.check())
						{
							cout << "invalid position please try again\n";
							goto poss;
							break;
						}
						carList.addCarAtPosition(carname, carmodel, carcolor, yearofpublished, priceperday, car_id, position);
						break;
					}
					default:
						cout << "Invalid choice\n";
						break;
					}
					break;
				}
				case 2:
					carList.listAllCars();
					break;
				case 3:
					carList.generateReports();
					break;
				case 4:
					carList.update();
					break;
				case 5:
					int ch;
					cout << "1. delete first car\n";
					cout << "2. delete last  car\n";
					cout << "3. delete at middle  car\n";
bac:
					cout << "please select option to delete car\n";
					cin >> ch;
					if (ch == 1)
					{
						carList.delete_first();
					}
					else if (ch == 2)
					{
						carList.delete_last();
					}
					else if (ch == 3)
					{
						carList.delete_pos();
					}
					else
					{
						cout << "invalid choice\n";
						goto bac;
					}
					break;
					
			
				case 9:
				{
					goto back;
					break;
				}
				case 0:
					cout << "Exiting program.\n";
					exit(0);
					break;
				default:
					cout << "Invalid choice\n";
					break;
				}
			}
			break;
		}
		case 2:
			while (1)
			{
				int choice;
				cout << "1. List all cars\n";
				cout << "2. Rent a car\n";
				cout << "3. Generate reports\n";
				cout << "4. Return a car\n";
				cout << "5. to back into main function\n";
				cout << "0. Exit\n";
				cout << "---------------------------------\n";
				cin >> choice;
				system("cls");
				cout << "-------------------------------------------------------------------------------------------" << endl;
				switch (choice)
				{
				case 1:
					carList.listAllCars();
					break;
				case 2:
				{
					if (carList.check() == 0)
					{
						cout << " no car avialable to rent" << endl;
					}
					else
					{
						int carid;
						int phonenum, day;
						string address, customername;
						int age;
						float tax;
						cout << "Enter customer name : ";
						cin >> customername;
						cout << "Enter customer phone number : ";
						cin >> phonenum;
						cout << "Enter customer address: ";
						cin >> address;
						cout << "how many day u want to rent: ";
						cin >> day;
age:
						cout << "Enter customer age: ";
						cin >> age;
						if (age < 18 || age > 80)
						{
							cout << "invalid age\n";
							goto age;
							break;
						}
						cout << "Enter position( not id) to rent from: ";
						cin >> carid;
						carList.rentCar(customername, phonenum, address, age, carid, day, tax);
						break;
					}
				}
				case 3:
					carList.generateReports();
					break;
				case 4:
				{
					int returncar_id;
					cout << "Enter car id to return: ";
					cin >> returncar_id;
					carList.returnCar(returncar_id);
					break;
				}
				case 5:
				{
					goto back;
					break;
				}
				case 0:
					cout << "Exiting program.\n";
					exit(0);
					break;
				default:
					cout << "Invalid choice\n";
					break;
					break;
				}
			}
			break;
		default:
			cout << "invalid choice" << endl;
		}
	}
	while (choice != 0);

	return 0;
}

