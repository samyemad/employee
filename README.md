# 🐘 Youwe Symfony Coding Challenge 🐘

## Description

Greetings! I've you're looking at this file, it means that you've been handed a Youwe Symfony Coding Challenge!

You *need* to have [`ddev`](https://ddev.readthedocs.io/en/stable/#installation) installed to run this stack.

## Steps

1. Clone this repo, follow the steps, and ultimately, push it to your own repo, and forward the access credentials if not public to the recruiter which has contacted you.

2. Run `ddev start`. Composer install and bringing the DB to state will happen automagically.

3. Don't worry about the certs, hostnames, all that jazz, the project will pop-up at  [http://youwe-symfony-coding-challenge.ddev.site/](http://youwe-symfony-coding-challenge.ddev.site/)

4. If you need to interact with `bin/console` or the shell of the `web` container, run `ddev ssh`

5. If you need to interact with `composer`, you can run `ddev composer <<insert_Composer_command_here>>`

6. Run the tests with `ddev run-tests`

7. Tests are also automatically running when you run `ddev stop`, so pay attention to the output
8. To turn on XDebug, tun `ddev xdebug` or `ddev xdebug on`, to turn it off, run `ddev xdebug off`. For help with mapping with your IDE of choice, click [here](https://ddev.readthedocs.io/en/stable/users/step-debugging/).
9. When you create new fixtures for tests in `tests/Controller/fixtures`, run `ddev update-snapshots` to automatically generate JSON files in `__snapshots__` directory for an easy assertion.
10. Check the `TODOs`, they might give you hints about what should be done.
11. Make sure that the failing tests/incomplete tests are completed.

No need to worry about containers, DB name/username/password, we're taking care of it.

## Objectives

- Set up Authentication/Authorization for the API based on JWT (use Symfony's Security and `lexik/jwt-authentication-bundle`, there's already `security.yaml` in the codebase, tweak it as per your needs). There's a required Basic HTTP Auth requirement to GET the token (check `TokenController` and `security.yaml`). All the other requests should be coming from `ROLE_USER`, except for the `DELETE` request, which should be done by `ROLE_ADMIN`. The respective auth's are `api_user/api_user` and `api_admin/api_admin`. 
- Use Symfony's Serializer to transform the Employee and YouweTeam entities into a JSON representation
- Make sure that all JSON property names are formatted in _snake_case_
- Add an **Employee** to one of the **Youwe Teams** and create the fixtures collection to test the endpoints.
- Implement **pagination** to the list GET endpoints (`/youwe_teams` and `/employees`) by means of your choice and create the fixtures collection to test the endpoints.
- Create endpoints to **create**, **update** and **delete** **Employees**. Be RESTful, mind the correct returns of the status codes.
- **Validate** the **create** and **update** endpoints of Employees using Symfony's Validation (first/last names and email should be required, email should be an email). 

## Hints
- Take a look at the documentation for [AliceDataFixtures](https://github.com/theofidry/AliceDataFixtures), because you can add relations to entities in the fixtures as well, by calling adding `__calls` keyword in the YAML fixtures, which may call a method to add a child fixture within the parent, e.g.:
```
App\Entity\Alpha:
    alpha_1:
        __construct: ['some', 'arguments']
        __calls:
            - addBeta: ['@beta_1']
            - addBeta: ['@beta_2']
            - addBeta: ['@beta_2']
                ...
App\Entity\Beta:
    beta_1:
        __construct: ['some', 'arguments']
    beta_2:
        __construct: ['some', 'arguments']
```
- Pay attention to how test fixtures (in `/tests/Controller/fixtures`) are automatically generating JSON files in `__snapshots__` based on the provided YAMLs in `fixtures`, after running the `ddev update-snapshots` command.