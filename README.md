### installation guide :- 

```sudo docker-compose build```

```sudo docker-compose up -d```

```sudo docker-compose exec php bash```

```composer update```

```exit```


##### add this url to your machine hosts 

```githubsearch.dev```



##### running the api test

```codecept run api```


##### running the unit test

```codecept run unit```


##### set you access token here from your github account in app/config/env.php

```
<?php

defined('GITHUB_ACCESS_TOKEN') or define('GITHUB_ACCESS_TOKEN', '{{set you access token here from your github account}}');

```

##### test url

```
http://githubsearch.dev/api/git/search?q=addClass&page=1&per_page=5&sort=indexed&order=desc
```
