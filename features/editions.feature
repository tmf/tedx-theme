Feature: Organize talks and their respective speakers by edition
    In order group talks by edition, which occurs yearly
    As a publisher
    I need to be able to specify a date for each talk

    Background:
        Given I have a vanilla wordpress installation
            | name          | email                   | username  | password   |
            | TEDxZurich    | tom.forrer@gmail.com    | publisher | secret     |
        And the "tedx-theme" theme is installed
        And I am logged in as "publisher" with password "secret"

    Scenario:
        Given there are speaker posts
            | post_title        | post_status   |
            | John              | publish       |
            | Emily             | publish       |
            | Richard           | publish       |
        And there are talk posts
            | post_title        | speaker   | post_status |
            | Talk by John      | John      | publish     |
            | Talk by Emily     | Emily     | publish     |
            | Talk by Richard   | Richard   | publish     |
            | Talk by Emily     | Emily     | publish     |
