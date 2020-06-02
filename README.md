# MSCBackUP
Utility for backup &amp; restore database on many version PHP &amp; MSQL

Once I needed to transfer data from a database to a server on PHP 5.3 (MySQL 5.6). to a server with PHP 7.3 (MySQL 5.5.5-10.3.16-MariaDB).
I realized that it’s easier to write myself.

If someone comes in handy I will only be glad.

Fundamental differences from the solutions I found:
- mobile and full version (thanks Bootstrap)
PHP and so:
- Support for both MySQLi and MySQL;
- Work with all types of tables and translate them into UTF-8;
- on the server and in the archive;
- Localization of English and Russian;
Ability to create archives from a remote server.
Copy files from a remote server.

You use this software at your own risk.
And, of course, I cannot be held responsible for any damage.

For correct operation it is necessary to set permissions to the "backups" -777 directory.
The key to correctly connect to the remote server.

<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_01.png" />
<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_02.png" />
<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_03.png" />
<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_04.png" />
<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_05.png" />
<img src="https://raw.githubusercontent.com/mscdeveloper/MSCBackUP/master/_TEMP_IMG/mscback_06.png" />

# MSCBackUP
Однажды мне понадобилось перенести данные из базы данных с сервера на PHP 5.3 (MySQL 5.6). на сервер с PHP 7.3(MySQL 5.5.5-10.3.16-MariaDB).
В результате поисков готовых решения я понял, что проще написать самому.

Если кому-то пригодится буду только рад. 

Принципиальные отличия от найденных мной решений:
- мобильная и полная версия (спасибо Bootstrap )
- Поддержка как старых версий PHP так и новых:
- Поддержка как MySQLi так и MySQL;
- Работа со всеми типами таблиц и перевод их в UTF-8;
- Выбор только тех таблиц с которыми нужно работать  как на сервере так и в архиве;
- Локализация Английская и Русская;
- Возможность создавать архивы с удаленного сервера на котором тоде находится эта     программа.
- Ну и бонусом копирование файлов изображений с удаленного сервера.

Вы используете данное программное обеспечение на свой страх и риск.
И конечно я снимаю с себя ответственность за любой ущерб причиненный по причине использования этой программы.

Для корректной работы необходимо установить права каталогу "backups" -777.
В файле измените ключ для корректной стыковки с удаленным сервером.

<a href="https://stackoverflow.com/users/8656248/mscdeveloper"><img src="https://stackoverflow.com/users/flair/8656248.png" width="208" height="58" alt="profile for mscdeveloper at Stack Overflow, Q&amp;A for professional and enthusiast programmers" title="profile for mscdeveloper at Stack Overflow, Q&amp;A for professional and enthusiast programmers"></a>
