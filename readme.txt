#
Description
Support the Puzzle application by providing a touchpoint for image upload and UID retreival

## Open Questions
* Are images uploaded all at once or in sequence?
* Are images being validated(size,type,naming etc)  on the client side?
* What are limits?
* Origin(IP address)?
* Frequency?
* Size/Format etc of inputs
* Are we using POST or GET?

## Functional Requirements
Use HTACCESS file to handle requests
[.] Handle valid requests to upload images
[.]	Respond with success/failure
[.]	Respond with proper UID
[.] Handle valid requests for list of IDs
[.]	Respond with list of UID 
Rename images appropriately and store on server
Save data to DB and ensure uniqueness, validity, security

Handle invalid requests


## Inputs
Format: JSON
Upload:
	firstname?
	lastname?
	other?
UID:
	?

## Outputs
Format: JSON
Upload:
Success/Failure

UID:


