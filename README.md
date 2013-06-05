# futaba.php

futaba.php is Message board scripts.

I branched script to this repository.
Is script used in http://www.2chan.net/.

This script aims running with PHP 5.4.15 or later...

# How to running

- PHP 5.4.15 or later

```
> php -S localhost:3000 -t .
```

# ToDo

Script charactor code is UTF-8, But previous code is Shift-JIS. 
There is a problem of compatibility of the log charactor code.

## Countermeasure

Use by nkf (Nihongo Kanji Filter).

```
> nkf -Lu old.log > new.log
```

# Lisence

This script for License is Public-domain.
I accordance with the distribution of the [original license](http://www.2chan.net/script/).
