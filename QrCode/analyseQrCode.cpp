#include <opencv2/objdetect.hpp>
#include <opencv2/imgcodecs.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
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
		inputImage = imread("png_random.png");

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
}