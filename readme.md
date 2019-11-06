-- Instruction on how to run the userimport project
-- 
-- Step 1: Go to the project root folder and copy .env.example to .env
-- Step 2: In command line, go to the root of the project and run  php artisan key:generate (This will add the Application key to the .env file)
-- Step 3: Open the configuration file .env in your IDE or notepad and update the database components with the correct username, password, host and database name, then save the file.
-- Step 4: Go back to the command line and run composer update
-- Step 5: In command line run php artisan migrate 
-- Step 6: Use an API tool such as postman to upload the user csv file
		
		
Note: the commands are to be run on the server where the php codes reside and in the root folder of the project.