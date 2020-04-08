# kata-card-drawer

A simple card drawer kata. Enjoy.

### Setup:

1. Clone this repository and `cd` into the project.
2. Run the docker stack: `docker-compose build && docker-compose up -d && docker exec -it sf5_php bash`
3. Install the required packages through composer: `cd sf5 && composer install` (go get you some coffee meanwhile)
4. Use `bin/console app:hand:generator -h` to have some help about this kata.

### Examples:

- `bin/console app:hand:generator 10` to get 10 cards from a 52 cards deck, then sorting them by their values (ASC)
- `bin/console app:hand:generator 15 sort-desc` to get 15 cards from a 52 cards deck, then sorting them by their values (DESC)
