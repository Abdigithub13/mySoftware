import java.io.*;
import java.util.*;

class Contact implements Serializable {
    private String name;
    private String phoneNumber;

    public Contact(String name, String phoneNumber) {
        this.name = name;
        this.phoneNumber = phoneNumber;
    }

    public String getName() {
        return name;
    }

    public String getPhoneNumber() {
        return phoneNumber;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setPhoneNumber(String phoneNumber) {
        this.phoneNumber = phoneNumber;
    }

    @Override
    public String toString() {
        return "Name: " + name + ", Phone Number: " + phoneNumber;
    }
}

class ContactManager {
    private List<Contact> contacts;

    public ContactManager() {
        contacts = new ArrayList<>();
    }

    public void addContact(Contact contact) {
        contacts.add(contact);
    }

    public boolean editContact(String name, String newPhoneNumber) {
        for (Contact contact : contacts) {
            if (contact.getName().equals(name)) {
                contact.setPhoneNumber(newPhoneNumber);
                return true;
            }
        }
        return false;
    }

    public boolean deleteContact(String name) {
        for (Contact contact : contacts) {
            if (contact.getName().equals(name)) {
                contacts.remove(contact);
                return true;
            }
        }
        return false;
    }

    public List<Contact> searchContact(String keyword) {
        List<Contact> searchResults = new ArrayList<>();
        for (Contact contact : contacts) {
            if (contact.getName().contains(keyword) || contact.getPhoneNumber().contains(keyword)) {
                searchResults.add(contact);
            }
        }
        return searchResults;
    }

    public List<Contact> getAllContacts()a {
        return contacts;
    }

    public void saveContactsToFile(String filename) throws IOException {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(filename))) {
            oos.writeObject(contacts);
        }
    }

    public void loadContactsFromFile(String filename) throws IOException, ClassNotFoundException {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(filename))) {
            contacts = (List<Contact>) ois.readObject();
        }
    }
}

class ContactManagementSystem {
    private static Scanner scanner = new Scanner(System.in);
    private static ContactManager contactManager = new ContactManager();

    public static void main(String[] args) {
        showLoginPage();
    }

    private static void showLoginPage() {
        System.out.println("Login Page");
        System.out.println("1. Client-side Page");
        System.out.println("2. Admin-side Page");
        System.out.print("Enter your choice: ");

        int choice = scanner.nextInt();
        scanner.nextLine(); // Consume newline character

        switch (choice) {
            case 1:
                showClientSidePage();
                break;
            case 2:
                showAdminSidePage();
                break;
            default:
                System.out.println("Invalid choice");
                break;
        }
    }

    private static void showClientSidePage() {
        System.out.println("Client-side Page");

        while (true) {
            System.out.println("1. Search Contact");
            System.out.println("2. View All Contacts");
            System.out.println("3. Exit");
            System.out.print("Enter your choice: ");

            int choice = scanner.nextInt();
            scanner.nextLine(); // Consume newline character

            switch (choice) {
                case 1:
                    searchContact();
                    break;
                case 2:
                    viewAllContacts();
                    break;
                case 3:
                    return;
                default:
                    System.out.println("Invalid choice");
                    break;
            }
        }
    }

    private static void showAdminSidePage() {
        System.out.println("Admin-side Page");

        while (true) {
            System.out.println("1. Add Contact");
            System.out.println("2. Edit Contact");
            System.out.println("3. Delete Contact");
            System.out.println("4. Search Contact");
            System.out.println("5. View All Contacts");
            System.out.println("6. Save Contacts to File");
            System.out.println("7. Load Contacts from File");
            System.out.println("8. Exit");
            System.out.print("Enter your choice: ");

            int choice = scanner.nextInt();
            scanner.nextLine(); // Consume newline character

            switch (choice) {
                case 1:
                    addContact();
                    break;
                case 2:
                    editContact();
                    break;
                case 3:
                    deleteContact();
                    break;
                case 4:
                    searchContact();
                    break;
                case 5:
                    viewAllContacts();
                    break;
                case 6:
                    saveContactsToFile();
                    break;
                case 7:
                    loadContactsFromFile();
                    break;
                case 8:
                    return;
                default:
                    System.out.println("Invalid choice");
                    break;
            }
        }
    }

    private static void addContact() {
        System.out.print("Enter name: ");
        String name = scanner.nextLine();

        System.out.print("Enter phone number: ");
        String phoneNumber = scanner.nextLine();

        Contact contact = new Contact(name, phoneNumber);
        contactManager.addContact(contact);

        System.out.println("Contact added successfully.");
    }

    private static void editContact() {
        System.out.print("Enter name of the contact to edit: ");
        String name = scanner.nextLine();

        System.out.print("Enter new phone number: ");
        String newPhoneNumber = scanner.nextLine();

        boolean success = contactManager.editContact(name, newPhoneNumber);

        if (success) {
            System.out.println("Contact edited successfully.");
        } else {
            System.out.println("Contact not found.");
        }
    }

    private static void deleteContact() {
        System.out.print("Enter name of the contact to delete: ");
        String name = scanner.nextLine();

        boolean success = contactManager.deleteContact(name);

        if (success) {
            System.out.println("Contact deleted successfully.");
        } else {
            System.out.println("Contact not found.");
        }
    }

    private static void searchContact() {
        System.out.print("Enter keyword to search: ");
        String keyword = scanner.nextLine();

        List<Contact> searchResults = contactManager.searchContact(keyword);

        if (searchResults.isEmpty()) {
            System.out.println("No matching contacts found.");
        } else {
            System.out.println("Matching contacts:");
            for (Contact contact : searchResults) {
                System.out.println(contact);
            }
        }
    }

    private static void viewAllContacts() {
        List<Contact> allContacts = contactManager.getAllContacts();

        if (allContacts.isEmpty()) {
            System.out.println("No contacts found.");
        } else {
            System.out.println("All contacts:");
            for (Contact contact : allContacts) {
                System.out.println(contact);
            }
        }
    }

    private static void saveContactsToFile() {
        try {
            System.out.print("Enter filename to save contacts: ");
            String filename = scanner.nextLine();

            contactManager.saveContactsToFile(filename);

            System.out.println("Contacts saved to file successfully.");
        } catch (IOException e) {
            System.out.println("Error saving contacts to file: " + e.getMessage());
        }
    }

    private static void loadContactsFromFile() {
        try {
            System.out.print("Enter filename to load contacts from: ");
            String filename = scanner.nextLine();

            contactManager.loadContactsFromFile(filename);

            System.out.println("Contacts loaded from file successfully.");
        } catch (IOException | ClassNotFoundException e) {
            System.out.println("Error loading contacts from file: " + e.getMessage());
        }
    }
}