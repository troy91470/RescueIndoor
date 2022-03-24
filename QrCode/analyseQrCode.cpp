#include <opencv2/objdetect.hpp>
#include <opencv2/imgcodecs.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
#include <unistd.h>
#include <iostream>
#include <regex>

using namespace cv;
using namespace std;

bool is_office(std::string chaine){
	if (chaine.empty())
	{
		return false;
	}
	
    std::string pattern("[0-9]"); // Regex expression
    std::regex rx(pattern);       // Getting the regex object

    std::ptrdiff_t nbrePattern = std::distance(std::sregex_iterator(chaine.begin(), chaine.end(), rx), std::sregex_iterator());
//    std::cout << nbrePattern << std::endl;  // Displaying results
	if (nbrePattern!=0) {
		return true;
	}
	return false;
}

int main(int argc, char *argv[])
{
	// Read image
	Mat inputImage;
	if (argc > 1)
		inputImage = imread(argv[1]);
	else
		inputImage = imread("png_random.pngg");

	QRCodeDetector qrDecoder = QRCodeDetector();

	Mat bbox, rectifiedImage;

	std::string data = qrDecoder.detectAndDecode(inputImage, bbox, rectifiedImage);
	if (is_office(data))
	{
		cout << "office:" << data << endl;
	}
	else{
		cout << "Office Code not detected" << endl;
	}


	VideoCapture cap(0);
	
	// decommenter pour afficher la video
	/*
	string window_name = "My Camera Feed";
	namedWindow(window_name); //create a window called "My Camera Feed"
	*/
	if (cap.isOpened() == false)  
	{
		cout << "Cannot open the video camera" << endl;
		cin.get();
		return -1;
	} else {
		// le return ci-dessus arrete le programme
	}

	while (true) {
		Mat frame;
		bool bSuccess = cap.read(frame); // read a new frame from video 

		//Breaking the while loop if the frames cannot be captured
		if (bSuccess == false) 
		{
		cout << "Video camera is disconnected" << endl;
		break;
		}

		// decommenter pour afficher la video
		/*
		imshow();
		*/
		//wait for for 10 ms until any key is pressed.  
		//If the 'Esc' key is pressed, break the while loop.
		//If the any other key is pressed, continue the loop 
		//If any key is not pressed withing 10 ms, continue the loop 
		if (waitKey(10) == 27)
		{
		cout << "Esc key is pressed by user. Stoppig the video" << endl;
		break;
		}
		std::string data = qrDecoder.detectAndDecode(frame, bbox, rectifiedImage);
		if (is_office(data))
		{
			cout << "office:" << data << endl;
		}
		usleep(500);
	}

}