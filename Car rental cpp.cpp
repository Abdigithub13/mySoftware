#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <chrono>
#include <ctime>

using namespace std;

// Vehicle structure
struct Vehicle {
    string make;
    string model;
    string type;
    string color;
    int year;
    double pricePerDay;
    bool available;
};

// Rental Agreement structure
struct RentalAgreement {
    int agreementNumber;
    string customerName;
    string customerID;
    string vehicleMake;
    string vehicleModel;
    string rentalDate;
    int rentalDays;
    double totalCost;
};

// Customer structure
struct Customer {
    string name;
    string address;
    string phone;
    string email;
   int age;
};

// Car Rental class
class CarRental {
    private:
    string ownerPassword = "ab";
        vector<Vehicle> inventory;
        vector<RentalAgreement> agreements;
        vector<Customer> customers;
        int nextAgreementNumber = 1;
    public:
        // Load data from file
        void loadData() {
            ifstream infile("inventory.txt");
            if (infile.is_open()) {
                Vehicle vehicle;
                while (infile >> vehicle.make >> vehicle.model >> vehicle.type >> vehicle.year >> vehicle.pricePerDay >> vehicle.available) {
                    inventory.push_back(vehicle);
                }
                infile.close();
            }
            infile.open("rental_agreements.txt");
            if (infile.is_open()) {
                RentalAgreement agreement;
                while (infile >> agreement.agreementNumber >> agreement.customerName >> agreement.customerID >> agreement.vehicleMake >> agreement.vehicleModel >> agreement.rentalDate >> agreement.rentalDays >> agreement.totalCost) {
                    agreements.push_back(agreement);
                }
                infile.close();
            }
            infile.open("customers.txt");
            if (infile.is_open()) {
                Customer customer;
                while (getline(infile, customer.name)) {
                    getline(infile, customer.address);
                    getline(infile, customer.phone);
                    getline(infile, customer.email);
                    customers.push_back(customer);
                }
                infile.close();
            }
        }

        // Save data to file
        void saveData() {
            ofstream outfile("inventory.txt");
            for (int i = 0; i < inventory.size(); i++) {
                outfile << inventory[i].make << " " << inventory[i].model << " " << inventory[i].type << " " << inventory[i].year << " " << inventory[i].pricePerDay << " " << inventory[i].available << endl;
            }
            outfile.close();
            outfile.open("rental_agreements.txt");
            for (int i = 0; i < agreements.size(); i++) {
                outfile << agreements[i].agreementNumber << " " << agreements[i].customerName << " " << agreements[i].customerID << " " << agreements[i].vehicleMake << " " << agreements[i].vehicleModel << " " << agreements[i].rentalDate << " " << agreements[i].rentalDays << " " << agreements[i].totalCost << endl;
            }
            outfile.close();
            outfile.open("customers.txt");
            for (int i = 0; i < customers.size(); i++) {
                outfile << customers[i].name << endl << customers[i].address << endl << customers[i].phone << endl << customers[i].email << endl;
            }
            outfile.close();
        }

        // Add a vehicle to the inventory
        void addVehicle() {
        string password;
        cout << "Enter owner password: ";
        cin >> password;
        if (password != ownerPassword) {
            cout << "Incorrect password. You are not authorized to perform this action." << endl;
            return;
        }
        cout<<"you can add car now"<<endl;
Vehicle vehicle;
      cout<<"Enter make:";
cin>>vehicle.make;
cout<<"Enter color:";
cin>>vehicle.color;
cout<<"Enter model:";
cin>>vehicle.model;
cout<<"Enter type:";
cin>>vehicle.type;
tj:
cout<<"Enter year:";
cin>>vehicle.year;
if(vehicle.year>2023){
cout<<"Invalid year.Year must be lower 2023."<<endl;
goto tj;
return;
}
price:
cout<<"Enter price per day:";
cin>>vehicle.pricePerDay;
if(vehicle.pricePerDay<500){
	cout<<"invalid price try again"<<endl;
goto price;
}
vehicle.available=true;
inventory.push_back(vehicle);
cout<<"Vehicle added to inventory."<<endl;
saveData();
}

        // List all available vehicles
        void listAvailableVehicles() {
            cout << "Available Vehicles:" << endl;
            for (int i = 0; i < inventory.size(); i++) {
                if (inventory[i].available) {
                    cout <<i<<"\t"<< inventory[i].make << " " << inventory[i].model << " " << inventory[i].type << " " << inventory[i].year << " $" << inventory[i].pricePerDay << "/day" << endl;
                }
            }
        }

        // Rent a vehicle
        void rentVehicle() {
        int index;
        string customerName,customerID,rentalDate;
int rentalDays;
double totalCost;
listAvailableVehicles();
cout<<"Enter the index of the vehicle to rent:";
cin>>index;
if(index<0||index>=inventory.size()||!inventory[index].available){
cout<<"Invalid selection."<<endl;
return;
}
cout<<"Enter customername:";
cin.ignore();
getline(cin,customerName);
cout<<"Enter customer ID:";
getline(cin,customerID);
cout<<"Enter rental date(MM/DD/YYYY):";
getline(cin,rentalDate);
day:
cout<<"Enter number of rental days:";
cin>>rentalDays;
if(rentalDays<=0){
	cout<<"invalid number of rental days try again";
	goto day;
}
totalCost=rentalDays*inventory[index].pricePerDay;
inventory[index].available=false;
RentalAgreement agreement={nextAgreementNumber++,customerName,customerID,inventory[index].make,inventory[index].model,rentalDate,rentalDays,totalCost};
agreements.push_back(agreement);
cout<<"Vehicle rented."<<endl;
saveData();
}


        // Return a vehicle
        void returnVehicle() {
        int agreementNumber;
            cout << "Enter the agreement number: ";
            cin >> agreementNumber;
            if (agreementNumber < 1 || agreementNumber > agreements.size()) {
            cout << "Invalid agreement number." << endl;
            return;
        }
            for (int i = 0; i < agreements.size(); i++) {
                if (agreements[i].agreementNumber == agreementNumber) {
                    for (int j = 0; j < inventory.size(); j++) {
                        if (inventory[j].make == agreements[i].vehicleMake && inventory[j].model == agreements[i].vehicleModel) {
                            inventory[j].available = true;
                            break;
                        }
                    }
                    agreements.erase(agreements.begin() + i);
                    cout << "Vehicle returned." << endl;
                    saveData();
                    return;
                }
            }
            cout << "Invalid agreement number." << endl;
        }

        // Add a customer
        void addCustomer() {
            Customer customer;
            cout << "Enter name: ";
            cin.ignore();
            getline(cin, customer.name);
            age:
			cout<<"enter customer age";
        cin>>customer.age;
           if (customer.age < 18 || customer.age >= 70) {
            cout << "Invalid age. Age must be within the allowed range (18-70)." << endl;
            goto age;
			return;
        }
            cout << "Enter address: ";
            getline(cin, customer.address);
            cout << "Enter phone: ";
            getline(cin, customer.phone);
            cout << "Enter email: ";
            getline(cin, customer.email);
            customers.push_back(customer);
         
              cout << "Customer added." << endl;
            saveData();
        }

        // Generate a report of rental agreements
        void generateReport() {
           double totalRevenue=0;
cout<<"Rental Agreements Report:"<<endl;
for(int i=0;i<agreements.size();i++){
cout<<"Agreement Number  \t"<<agreements[i].agreementNumber<<endl;
cout<<"Customer Name  \t"<<agreements[i].customerName<<endl;
cout<<"Vehicle Make  \t"<<agreements[i].vehicleMake<<endl;
cout<<"Vehicle Model  \t"<<agreements[i].vehicleModel<<endl;
cout<<"Rental Date  \t"<<agreements[i].rentalDate<<endl;
cout<<"Rental Days  \t"<<agreements[i].rentalDays<<endl;
cout<<"Total Cost  \t"<<"$"<<agreements[i].totalCost<<endl;
totalRevenue+=agreements[i].totalCost;
}
cout<<"Total Revenue: $"<<totalRevenue<<endl;
}
        // Display main menu
        void displayMenu() {
            int choice;
            do {
                cout << endl << "Car Rental Management System" << endl;
                cout << "1. Add Vehicle" << endl;
                cout << "2. List Available Vehicles" << endl;
                cout << "3. Rent Vehicle" << endl;
                cout << "4. Return Vehicle" << endl;
                cout << "5. Add Customer" << endl;
                cout << "6. Generate Report" << endl;
                cout << "0. Exit" << endl;
                cout << "Enter choice: ";
                cin >> choice;
                switch (choice) {
                    case 1:
                        addVehicle();
                        break;
                    case 2:
                        listAvailableVehicles();
                        break;
                    case 3:
                        rentVehicle();
                        break;
                    case 4:
                        returnVehicle();
                        break;
                    case 5:
                        addCustomer();
                        break;
                    case 6:
                        generateReport();
                        break;
                    case 0:
                        break;
                    default:
                        cout << "Invalid choice." << endl;
                        break;
                }
            } while (choice != 0);
        }
};

int main() {

 int again = 0;
    cout << "WELCOME TO OUR CAR RENTAL PLACE!!" << endl;

    
     string rentalPassword;
    string ownerPassword = "ab";
   
    while (again < 3) {
     CarRental carRental;
            carRental.loadData();
            if (rentalPassword == ownerPassword) {
                carRental.addVehicle();
            }
            carRental.displayMenu();
            break;
        }
     //   else
         {
            cout << "Incorrect password. Please try again." << endl;
            again++;
        }
    
    if (again >= 3) {
        cout << "Too many incorrect attempts. Program terminated." << endl;
    }
    return 0;
}
/*

This program uses a class called `CarRental` to manage the vehicle inventory, rental agreements, customers, and more. The program loads data from files when it starts up and saves data to files when changes are made. The program also includes functions for adding a vehicle, listing available vehicles, renting a vehicle, returning a vehicle, adding a customer, generating a report, and displaying a menu for the user to select options from.

Note that this is just an example program and there are many ways to implement a car rental management system. */

