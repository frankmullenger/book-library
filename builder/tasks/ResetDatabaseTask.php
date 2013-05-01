<?php

class ResetDatabaseTask extends BuildTask {
	
	protected $title = "Reset database";
	
	protected $description = "Reset the database to a blank canvas";

	static $fixture_file = 'builder/tasks/Reset.yml';
	
	function run($request) {

		$dbAdmin = DatabaseAdmin::create();
		increase_time_limit_to(600);
		SS_ClassLoader::instance()->getManifest()->regenerate();

		//Clear and rebuild database
		$dbAdmin->clearAllData();
		$dbAdmin->doBuild(true);
		
		//Move images to assets/Uploads/
		$assetsDir = Director::baseFolder() . '/assets/Uploads';
		$imagesDir = Director::baseFolder() . '/builder/images';

		foreach (new DirectoryIterator($assetsDir) as $fileInfo){
			if(!$fileInfo->isDot()) {
				@unlink($fileInfo->getPathname());
			}
		}
		
		Filesystem::sync();

		foreach (new DirectoryIterator($imagesDir) as $fileInfo){
			if($fileInfo->isFile()) {
				copy($fileInfo->getPathname(), $assetsDir . '/' . $fileInfo->getFilename());
			}
		}

		//Build database
		$fixture = new YamlFixture(Director::getAbsFile(self::$fixture_file));
		$model = DataModel::inst();
		$fixture->saveIntoDatabase($model);
		
		//Create home page
		if (class_exists('AppPage')) {
			$page = Page::get()
				->where("\"URLSegment\" = 'home'")
				->first();

			$page->ClassName = 'AppPage';
			$page->doPublish();
			
			$page = Page::get()
				->where("\"URLSegment\" = 'about-us'")
				->first();
			$page->doUnpublish();
			$page->delete();
			
			$page = Page::get()
				->where("\"URLSegment\" = 'contact-us'")
				->first();
			$page->doUnpublish();
			$page->delete();
		}
	}
}