// This C++ program implements the binary search, Max-Min problem, merge sort, and quick sort
// using a divide and conquer approach. The program takes user input for the array elements 
// and the element to search for in the binary search.
// binary search program work only if we insert sorted elements and
// this code accepts elements from keyboard first of all and then after solve all problems with that elements. 
// to implement this code first do binary search with sorted elements then after execute the program again
// and do the left problems. 
// the reason why i used vector is because ISO C++ forbids or doesn't support variable-size array. 
#include <iostream>
//#include <conio.h>
#include <vector>
#include <climits>
using namespace std;
int binarySearch(vector<int>& arr, int low, int high, int key)
{
	if (low > high)
	{
		return -1;
	}
	int mid = low + (high - low) / 2;
	if (arr[mid] == key)
	{
		return mid;
	}
	else if (arr[mid] > key)
	{
		return binarySearch(arr, low, mid - 1, key);
	}
	else
	{
		return binarySearch(arr, mid + 1, high, key);
	}
}
void maxMin(vector<int>& arr, int low, int high, int& maxVal, int& minVal)
{
	if (low == high)
	{
		maxVal = max(maxVal, arr[low]);
		minVal = min(minVal, arr[low]);
		return;
	}
	if (high - low == 1)
	{
		maxVal = max(maxVal, max(arr[low], arr[high]));
		minVal = min(minVal, min(arr[low], arr[high]));
		return;
	}
	int mid = low + (high - low) / 2;
	int max1 = INT_MIN, min1 = INT_MAX;
	int max2 = INT_MIN, min2 = INT_MAX;
	maxMin(arr, low, mid, max1, min1);
	maxMin(arr, mid + 1, high, max2, min2);
	maxVal = max(maxVal, max(max1, max2));
	minVal = min(minVal, min(min1, min2));
}
void merge(vector<int>& arr, int low, int mid, int high)
{
	int n1 = mid - low + 1;
	int n2 = high - mid;
	vector<int> L(n1), R(n2);
	for (int i = 0; i < n1; ++i)
	{
		L[i] = arr[low + i];
	}
	for (int j = 0; j < n2; ++j)
	{
		R[j] = arr[mid + 1 + j];
	}
	int i = 0, j = 0, k = low;
	while (i < n1 && j < n2)
	{
		if (L[i] <= R[j])
		{
			arr[k] = L[i];
			++i;
		}
		else
		{
			arr[k] = R[j];
			++j;
		}
		++k;
	}
	while (i < n1)
	{
		arr[k] = L[i];
		++i;
		++k;
	}
	while (j < n2)
	{
		arr[k] = R[j];
		++j;
		++k;
	}
}
void mergeSort(vector<int>& arr, int low, int high)
{
	if (low < high)
	{
		int mid = low + (high - low) / 2;
		mergeSort(arr, low, mid);
		mergeSort(arr, mid + 1, high);
		merge(arr, low, mid, high);
	}
}
int partition(vector<int>& arr, int low, int high)
{
	int pivot = arr[high];
	int i = low - 1;
	for (int j = low; j < high; ++j)
	{
		if (arr[j] < pivot)
		{
			++i;
			swap(arr[i], arr[j]);
		}
	}
	swap(arr[i + 1], arr[high]);
	return i + 1;
}
void quickSort(vector<int>& arr, int low, int high)
{
	if (low < high)
	{
		int pi = partition(arr, low, high);
		quickSort(arr, low, pi - 1);
		quickSort(arr, pi + 1, high);
	}
}
int main()
{
	cout << "Group members: \n";
	cout << "    Name             ID\n";
	cout << endl;
	cout << "1. Abdi Tolesa-------1401036\n";
	cout << "2. Biniam Yohannis---1302329\n";
	cout << "3. Eldana Ashenafi---1406430\n";
	cout << endl;
	int n;
	cout << "Enter the number of elements in the array: ";
	cin >> n;
	vector<int> arr(n);
	cout << "Enter " << n << " elements: \n";
	for (int i = 0; i < n; ++i)
	{
		cin >> arr[i];
	}
	int choice;
	do
	{  
        cout << endl;
		cout << "---------------------------------\n";
		cout << "           MENU \n";
		cout << "---------------------------------\n";
		cout << " press 1 for Binary Search \n";
		cout << " press 2 for Max-Min Problem \n";
		cout << " press 3 for Merge Sort \n";
		cout << " press 4 for Quick Sort \n";
		cout << " press 5 for Exit\n";
		cout << " Enter your choice: ";
		cin >> choice;
		//system("cls");
		switch (choice)
		{
		case 1:
		{
			int key;
			cout << "Enter the element to search: \n";
			cin >> key;
			// Binary Search
			int index = binarySearch(arr, 0, n - 1, key);
			if (index != -1)
			{
				cout << "Element found at index: " << index << endl;
			}
			else
			{
				cout << "Element not found" << endl;
			}
			break;
		}
		case 2:
		{
			// Max-Min Problem
			int maxVal = INT_MIN;
			int minVal = INT_MAX;
			maxMin(arr, 0, n - 1, maxVal, minVal);
			cout << "Max value in the array: " << maxVal << endl;
			cout << "Min value in the array: " << minVal << endl;
			break;
		}
		case 3:
		{
			// Merge Sort
			mergeSort(arr, 0, n - 1);
			cout << endl;
			cout << "Array after Merge Sort: ";
			for (int i = 0; i < n; ++i)
			{
				cout << arr[i] << " ";
			}
			cout << endl;
			break;
		}
		case 4:
		{
			// Quick Sort
			quickSort(arr, 0, n - 1);
			cout << endl;
			cout << "\\nArray after Quick Sort: ";
			for (int i = 0; i < n; ++i)
			{
				cout << arr[i] << " ";
			}
			cout << endl;
			break;
		}
		case 5:
			cout << "Exiting program...\n";
			break;
		default:
			cout << "Invalid choice. Please try again.\n";
		}
	}
	while (choice != 5);
	return 0;
}

