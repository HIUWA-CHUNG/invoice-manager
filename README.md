# Invoice Manager
- Name: **Hiu Wa Chung**
- Student Number: **041058137**
- Section Number: **CST8257-300**

What changes did you make when refactoring the project?
- use session to store the data
- made a form
- use isset
- use GET and POST

In your own words, what are the guidelines for knowing when to use $_POST over query strings and $_GET?
- $_POST : send the data entered through the URL, so _POST should be used for unsafe operations
- $_GET : send the data as part of the body of request, so GET should be used for safe operations

What are some limitations to using sessions for persistent data? What could be done to overcome those limitations?
- Large data handling can become a performance issue because session data is kept on the server. Data from reading and writing sessions can become slow. Optimise the use of sessions to lessen the performance hit. Use effective data types, and just save the session's necessary data.
