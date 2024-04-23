
# symfony_project

Project jest dostępny za adresem http://3.143.224.54/api (Api platform).

Strona główna dostępna za adresem : http://3.143.224.54

Dla zapisywania danech w loclną bazą danych z API REST https://jsonplaceholder.typicode.com polecenie konsoli zostało utworzone w folderze src/Command/FetchPostsCommand.
(Na serverze http://3.143.224.54/api już są pobrane posty i użykowniki)
Domyślna wartość hasła dla wszystkich użytkowników uzyskanych za pomocą polecenia FetchPostsCommand to "12345678".

Logowanie:
Dla logowania proszę skorzystać z /api/login: pszykład:
{
"email":"Lucio_Hettinger@annie.ca",
"password":"12345678"
}
Otrzymany "token" proszę wpisać do 'Authorize'. W access_token (apiKey) w wartości value: "Bearer "token""

Teraz jako do zalogowanego użytkownika. Pan/Pani ma dostęp do /api/posts oraz /api/user.

GET /api/posts - wydanie wszystkie posty z localnej bazy danych

POST /api/posts - twirzy nowy post dla zalogowanego użytkonika 
{
    "title":"title",
    "body":"body"
}

DETELE /api/posts/{id} - usuwa jeden post jeszeli zalogowany użytkownik jest jego właścicielem.

GET /api/user - wydaje dane urzytkownika

POST /api/user - tworzenia nowego urzytkowika:
{
"username": "username",
"email": "Illireerrea@example.com",
"name": "John Doe",
"password": "12345678",
"phone": "1234567890"
}
