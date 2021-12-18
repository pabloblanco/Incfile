# interviewexercise

 Notes:
 
      The file with the code for the point 2 is in the app/console/command/SendPostsToQueue.php file.
 
      The code that solves points 4 and 5 is in the /app/Jobs/SendPost.php file.
      
------------------------------------------------------------------------------------------------------------------------------      
 
 1.- Download or clone the project from the repository to an Apache or Nginx public directory on your server.
 
 ![ScreenHunter 2295](https://user-images.githubusercontent.com/11873645/144964244-ec9b781d-4644-478f-983c-d64c39130f7e.png)
 
 2.- Open a terminal in the project directory and execute de Artisan commands: 
 
    php artisan migrate
    
 then 

    php artisan incfile:sendpoststoqueue postQuantity
    
 replacing postQuantity for the number of posts that you want generate to proof the code.
 
 ![ScreenHunter 2296](https://user-images.githubusercontent.com/11873645/144964830-ee1b0530-0568-4f10-a68e-eb25cbce20f9.png)

 3.- Open a webbrowser and put the project address in your localhost, in case you use Laragon, put interviewexercise.test to monitor the code behavior
 
![ScreenHunter 2294](https://user-images.githubusercontent.com/11873645/144963968-5adca735-4915-4851-a38c-5dd40319c46a.png)

 4.- in the terminal execute the command: php artisan queue:work --queue=high,low
 
![ScreenHunter 2297](https://user-images.githubusercontent.com/11873645/144965179-c23895ba-8a53-4913-8838-9a5cba2d0e8f.png)

 5.- In order to clean Failed Jobs Table after the test, you can delete all of your failed jobs from the failed_jobs table, 
 you may use the queue:flush command: php artisan queue:flush
 
 ![ScreenHunter 2298](https://user-images.githubusercontent.com/11873645/144965579-7eea48d7-e0c1-479a-8145-6eaf3916208e.png)
