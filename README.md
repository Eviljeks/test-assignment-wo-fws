# Вимоги
- Додаток повинен бути розроблений з використанням MVC
- У браузері є форма з одним полем textarea
- Користувач може вводити у форму все, що хоче
- Після надсилання форми дані повинні бути записані в базу mysql під унікальним ідентифікатором.
- Після запису в базу даних необхідно вибрати ці дані і вивести на сторінку в браузері в такому ж вигляді як ввів користувач.
- Дані повинні бути надіслані на email та надіслані у вигляді SMS (потрібно реалізувати тільки класи), саму відправку робити не треба
- Обов'язково передбачити захист від SQL ін'єкцій, XSS, CSRF
- Інтерпретувати можна на власний смак.
- Оформлення в github

# Запуск
Для запуску потрібно:
1. docker-compose up -d
2. провести міграцію (можна через adminer, встановлений вже на 8080 порту)
```
CREATE TABLE `comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `text` varchar(512) NOT NULL
);
```