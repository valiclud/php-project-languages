<?php
class AuthorController {
	public function __construct(private DatabaseTable $authorsTable) {
    }

    public function registrationForm() {
        return [
          'template' => 'register.html.php',
            'title' => 'Register an account'
        ];
    }

    public function success() {  
          return [
            'template' => 'registersuccess.html.php',
            'title' => 'Registration Successful'
          ];
    }

    public function registrationFormSubmit() {
        $author = $_POST['author'];
        $errors = [];

        if (empty($author['email'])) {
            $errors[] = 'Email cannot be blank';
        } else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $errors[] = 'Invalid email address';
        } else { // If the email is not blank and valid:
            // convert the email to lowercase
            $author['email'] = strtolower($author['email']);

            // Search for the lowercase version of $author['email']
            if (count($this->authorsTable->find('email', $author['email'])) > 0) {
                $errors[] = 'That email address is already registered';
            }
        }

        if (empty($author['password'])) {
            $errors[] = 'Password cannot be blank';
        }
        // If there are no errors, proceed with saving the record in the database
        if (count($errors) === 0) {
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
			
            $this->authorsTable->save($author);

           header('Location: /author/success');
        } else {
            // If the data is not valid, show the form again
            return ['template' => 'register.html.php',
        'title' => 'Register an account',
        'variables' => [
            'errors' => $errors,
            'author' => $author
        ]
      ];
        }
    }
}