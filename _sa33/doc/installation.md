# Installation

The application provides a compatible docker environment which you can start by
executing the following command. This might take a while the first time. After
launch it logs into the PHP container where you can execute your commands.

```
./run.sh
```

From within the PHP container you can initialize the application as follows.

```
./reset.sh
```

Now you (should) have a running application. You can execute the following
script to check if everything is working properly.

```
./check.sh
```
