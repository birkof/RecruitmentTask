Recruitment Task
==========

> A Symfony project created on April 9, 2018, 11:25 pm.

	This software it is intended to be used for evaluation and demonstration purposes only.
	It provides ideas and examples on how to solve a specific problem or how to use a specific technology.
	No support is provided for this software type. Commercial use of it is not permitted.

## Install
    git clone git@github.com:birkof/RecruitmentTask.git
    cd RecruitmentTask
    cp .env.dist .env
    docker-compose up -d
    docker-compose exec php composer install --optimize-autoloader
    docker-compose exec php console d:s:u --force
    
## Usage
    docker-compose exec php console server:start 0.0.0.0:8000
    docker-compose exec php console a:o:p 1
    docker-compose exec php console a:o:p 2

### Requirements
To run this application on your machine, you need Docker & docker-compose installed locally.

## License
(The GPLv3 License)
see [LICENSE](./LICENSE) file for details...