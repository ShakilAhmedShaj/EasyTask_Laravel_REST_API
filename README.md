
## Backend REST API for [Easy Task](https://github.com/ShakilAhmedShaj/EasyTask_MVVM_Kotlin) Android App



## Routes
<pre>
User :

&gt; POST http://127.0.0.1:8000/api/register
&gt; POST http://127.0.0.1:8000/api/login
&gt; GET http://127.0.0.1:8000/api/users/detail/{id}
&gt; POST http://127.0.0.1:8000/api/users/edit/user

Task:

&gt; POST http://127.0.0.1:8000/api/task/add_task
&gt; POST http://127.0.0.1:8000/api/task/update_task
&gt; POST http://127.0.0.1:8000/api/task/delete_task
&gt; GET http://127.0.0.1:8000/api/task/get_all_task
&gt; GET http://127.0.0.1:8000/api/task/get_task_by_id/{id}

Token :

&gt; GET http://127.0.0.1:8000/api/validate_token
</pre>

### Built With

* [Laravel](https://laravel.com/)
* [Passport](https://laravel.com/docs/7.x/passport)


### Android App based on this REST API

* [Easy Task](https://github.com/ShakilAhmedShaj/EasyTask_MVVM_Kotlin)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
