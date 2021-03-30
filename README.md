# Wallbox api challenge

This projects tries to solve the api challenge requested by Wallbox.

This has been a funny chanllenge to solve and maybe I get a little fired up and ended creating a project bigger than needed and with lots of complexity to demonstrate my capabilities almost at full potential.

Here you will find a project that runs over docker containers, one with and Nginx server to give the http layer to connect to, and other with a php-fpm to run the php code. At the devops folder you will find the files used to configure and create the architecture layer. 

The chosed language to create the solution has been **PHP 8**, and the framework used has been **Symfony** at its latest version (ver 5.2.5 at the writing). It brings a little.... or to much... scaffolding to solve the challenge, but that brings me the opportunity to show the mastery of the tool.

As development methodologies I chosed to use TDD (to test the solution), with SOLID principles to create a reliable code, and the DDD practices to split the main code (the domain) from the framework and the infrastructure (external data files).

Last but not least, DDD practices are more of a set of guidelines than a set of rules, so my interpretation has been as follows (folder structure):
	
 - **project**: the whole project files
	 - **Wallbox**: the folder with the solution code and with its own namespace to be framework agnostic.
		 - **Domain**: folder with the domain logic, agnostic to the framework and the project architecture.
			 - Subdomain (**Users**): folder to logicaly group the problem to solve
				 - **Application**: folder with the entrance gateway to our solution, the layer that connects our code to the framework
				 - **Model**: folder with the needed entities declaration
				 - **Services**: here lays the logic of the solution, where the problems are solved. Also contains the repository interfaces, that way the code remains agnostic to the architecture
			 - **Infrastructure**: folder with the logic to connect to the outside world to save or retrieve the data (from database, files, in memory, api...).
			 - **Tests**: folder with the code to test all the created services. 

### Important

As we have seen the logic is on the service folder so we only should test that folder, cause that is the meaning of unit tests. But in this project we have to face the fact that the logic needed has been implemented at repository level, so for the sake demonstration the infrastructure has been test. 

## Folder structure

Do not panic, I won't repeat the Wallbox folder again, but I have to explain the surrounding structure and the modified files to personalise the solution:
- **devops**: folder containing the files to create the infratructure that will run the code, that means, the docker files and server configuration.
- **project**: folder with all the code, it means the framework and the loved Wallbox folder.
  - **config**: folder with the framework configurations
    - **routes.yaml**: file with the accepted routes configuration to be abailable as an API
    - **services.yaml**: file with the autowiring configuration used by the framework to perform the dependency injections.
  - **src**: folder where the framework logic goes
    - **Controller**: the gateway points from the outside, here starts the magic, or the pain. In its contained files arrive the user requests calls, then the domain code performs the operations, and finally the  response is build to return to the user.
  - **Wallbox**: here is.... I was joking, its been described before.

## Code execution

Ok, but, how to launch the project and start to access to the API?

First build the docker images and install vendors by: 

    make build

The first time will take some time, I recommend to go to take a coffe. That command will download the needed docker images and build new ones.

Then you can run the dockers:

    make run

Two services will be created:

 - **web_1**: the Nginx service to accept http requests
 - **php_1**: the php_fpm service to execute the php code

With that command you will be able to see the system logs. To stop the service press

    ctrl + c

The api access will be in:
http://localhost:8080/users

If you try to acces to the root url you will see the framework welcome page, its there for browser testing pourposes.

### Project api

There is only one access point, the one mentioned above, so, how can the solution be tested?

To get all the users contained on the users.csv file it is only necessary to access to the endpoint with a **GET request**. By default all the results will be always ordered by the name and surename fields.

Then, to be able to get the filtered results it is needed to access to the endpoint with a **json request** as shown below, and as the request is stateless we still use the **GET verb**:

    {
	    "countries": [
		    "SE",
		    "RU"
	    ],
	    "activation_length":  29
    }

We can use any, both or none of the filters.

 ## Tests execution

 You can execute the project tests by the following command:

     make tests

If the docker image does not exists it will create it, so the command will take some time to finish.
