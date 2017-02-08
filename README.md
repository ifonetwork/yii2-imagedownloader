Image Downloader for Yii2
================
Download and save images  from remote url  

Installation
------------


Add
```
"repositories": [
	{
	"type": "vcs",
	"url": "https://github.com/ifonetwork/yii2-imagedownloader"
	}
]
```

to the require section of your `composer.json` file.

Either run

```
composer require "ifonetwork/yii2-imagedownloader:*"
```

or add

```
"ifonetwork/yii2-imagedownloader": "*"
```

to the require section of your `composer.json` file.



Usage
-----

Once the extension is installed, simply use it in your code by  :

```
 $images = [
            'https://pp.vk.me/c837621/v837621463/23f8b/ZieqRh6--fI.jpg',
            'https://pp.vk.me/c837237/v837237713/21203/NyAN1WM9V0c.jpg',
            'https://pp.vk.me/c639431/v639431553/5757/dRxLftkmMTI.jpg',
        ];

        $downloader = new ImageDownloader($images);
        $downloader->savePath(\Yii::getAlias('@webroot')."/images/");
        $downloader->setPrefix('_from_vk_');

        if($downloader->download() ) {
          
		   // do something
            foreach ($downloader->filesList() as $item) {
                echo $item->getName();
            }
			
			

        } else {
			//display error
             $downloader->errors();
            $downloader->filesList();  // allready downloaded files

        }
```