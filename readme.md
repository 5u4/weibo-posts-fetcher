# Weibo Posts Fetcher

## Description

The tool is designed for fetching [Weibo](https://weibo.com) (Chinese Twitter) posts, 
filter out the duplications, 
and store them locally.
 
It saves user's time in browsing since most of the content are repeated (people retweet posts).

The tool uses PHP7 and MySQL.

API: [Weibo API](http://open.weibo.com/wiki/API)

## Initialize

1. Rename [conf.example](conf.example) to `conf` and fill out the settings

```
### Tool Settings ###
SEPARATED[boolean]: default true; Separate multiple users' posts into their own table
COUNT[int]: default 100; The number of posts each api request; Maximum 100
NUMBER_OF_PAGES[int]: default 5; Request pages, each page contains <COUNT> of posts
FEATURE[int]: default 0; Filter posts; 0: All; 1: Originals; 2: Pictures; 3: Videos; 4: Musics
```

```
### Weibo Settings ###
USERNAMES[array<string>]: Weibo usernames
ACCESS_TOKENS[array<string>]: Access token from http://open.weibo.com/tools/console
```

```
### Database Settings ###
DB_HOST[string]: default 'localhost'; Database Host
DB_PORT[string]: default 3306; Database Port
DB_DATABASE[string]: default 'weibo'; Database Name
DB_USER[string]: default 'root'; User
DB_PASSWORD[string]: default 'password'; Password
```

2. Create Database

```
MySQL> CREATE DATABASE <DB_DABATASE>
```

3. Initialize

```bash
php init
```

## How to Use

You can use it [when is needed](#when-needed) or [set a `crontab` job](#crontab) to fetch posts every day.

### When Needed

```bash
php fetch
```

### Crontab

```bash
crontab -e
```

Add the following to the file (replace `<directory>` to file directory)

```
0 */8 * * * (php <directory>/fetch)
```
