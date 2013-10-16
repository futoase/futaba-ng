# futaba.php

futaba.php is Message board scripts.

I branched script to this repository.
Is script used in http://www.2chan.net/.

This script aims running with PHP 5.4.15 or later...

# How to running

- PHP 5.4.15 or later

```
> cd app
> grunt concat:model
> grunt concat:futaba
> grunt shell:phpRunning
```

# ToDo

Script charactor code is UTF-8, But previous code is Shift-JIS. 
There is a problem of compatibility of the log charactor code.

## Countermeasure

Use by nkf (Nihongo Kanji Filter).

```
> nkf -Lu old.log > new.log
```

![みさわ](http://jigokuno.img.jugem.jp/20090928_1487687.gif)

# Lisence

This script for License is Public-domain.
I accordance with the distribution of the [original license](http://www.2chan.net/script/).


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/futoase/futaba-ng/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

