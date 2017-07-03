<?php

/* Filename: delpic.php
 * Feature: Find/Remove unused/unavailable product- and category images
 * Authors : jonas.hess@revier.de, info@foxido.de
 */

class delpic extends oxAdminDetails
{

    public function render()
    {
        parent::render();
        return "delpic.tpl";
    }

    public function delipic()
    {
        $myConfig = $this->getConfig();
        $oDb = oxDb::getDb(oxDB::FETCH_MODE_ASSOC);
        for ($i = 1; $i <= 12; $i++) {
            $aImgFilesArticles = Array();
            $sqlSelect = 'SELECT DISTINCT OXPIC' . $i . ' FROM oxarticles WHERE OXPIC' . $i . ' != "";';
            $result = $oDb->getAll($sqlSelect);
            foreach ($result as $row) {
                $aImgFilesArticles[] = $row['OXPIC' . $i];
            }

            // Generated Pictures
            $imgdir = $myConfig->getPictureDir(false) . 'generated/product/' . $i . '/';
            $sub_dirs = glob($imgdir . '*', GLOB_ONLYDIR);
            foreach ($sub_dirs as $sub_dir) {
                $files = array_filter(glob($sub_dir . '/*'), 'is_file');
                foreach ($files as $file) {
                    if (!in_array(basename($file), $aImgFilesArticles) && basename($file) != 'nopic.jpg') {
                        oxRegistry::get("oxUtilsView")->addErrorToDisplay('Obsolete File found: ' . $file);
                        if (oxRegistry::getConfig()->getRequestParameter("autodelete")) {
                            unlink($file);
                        }
                    }
                }
            }

            //Master Pictures
            $imgdir = $myConfig->getPictureDir(false) . 'master/product/' . $i . '/';
            $files = array_filter(glob($imgdir . '*'), 'is_file');
            $aFoundMaster = Array();
            foreach ($files as $file) {
                if (!in_array(basename($file),
                        $aImgFilesArticles) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
                ) {
                    oxRegistry::get("oxUtilsView")->addErrorToDisplay('Obsolete File found: ' . $file);
                    if (oxRegistry::getConfig()->getRequestParameter("autodelete")) {
                        unlink($file);
                    }
                } else {
                    $aFoundMaster[] = basename($file);
                }
            }
            $aNotFound = array_diff($aImgFilesArticles, $aFoundMaster);
            if (count($aNotFound) > 0) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay("Not found Article-Master in $imgdir :\n");
                foreach ($aNotFound as $notFoundItem) {
                    oxRegistry::get("oxUtilsView")->addErrorToDisplay("- $notFoundItem \n");
                }
            }
        }

        //Category Thumbnails
        $imgdir = $myConfig->getPictureDir(false) . 'master/category/thumb/';
        $aImgFilesCatThumbs = Array();
        $aFoundCatThumb = Array();
        $sqlQuery4Thumbs = "SELECT OXTHUMB, OXTHUMB_1, OXTHUMB_2, OXTHUMB_3 FROM oxcategories WHERE OXTHUMB!='' OR OXTHUMB_1 !='' OR OXTHUMB_2 !='' OR OXTHUMB_3 !='';";
        $result = $oDb->getAll($sqlQuery4Thumbs);
        foreach ($result as $row) {
            if ($row['OXTHUMB'] != '') {
                $aImgFilesCatThumbs[] = $row['OXTHUMB'];
            }
            if ($row['OXTHUMB_1'] != '') {
                $aImgFilesCatThumbs[] = $row['OXTHUMB_1'];
            }
            if ($row['OXTHUMB_2'] != '') {
                $aImgFilesCatThumbs[] = $row['OXTHUMB_2'];
            }
            if ($row['OXTHUMB_3'] != '') {
                $aImgFilesCatThumbs[] = $row['OXTHUMB_3'];
            }
        }
        $aImgFilesCatThumbs = array_unique($aImgFilesCatThumbs);
        $files = array_filter(glob($imgdir . '*'), 'is_file');
        foreach ($files as $file) {
            if (!in_array(basename($file),
                    $aImgFilesCatThumbs) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
            ) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('Obsolete File found: ' . $file);
                if (oxRegistry::getConfig()->getRequestParameter("autodelete")) {
                    unlink($file);
                }
            } else {
                $aFoundCatThumb[] = basename($file);
            }
        }
        $aNotFound = array_diff($aImgFilesCatThumbs, $aFoundCatThumb);
        if (count($aNotFound) > 0) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay("Not found Thumbnail in $imgdir :\n");
            foreach ($aNotFound as $notFoundItem) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay("- $notFoundItem \n");
            }
        }

        //Category Icons
        $imgdir = $myConfig->getPictureDir(false) . 'master/category/icon/';
        $aImgFilesCatIcons = Array();
        $aFoundCatIcon = Array();
        $sqlQuery4Icons = "SELECT DISTINCT OXICON FROM oxcategories where OXICON!='';";
        $result = $oDb->getAll($sqlQuery4Icons);
        foreach ($result as $row) {
            $aImgFilesCatIcons[] = $row['OXICON'];
        }

        $files = array_filter(glob($imgdir . '*'), 'is_file');
        foreach ($files as $file) {
            if (!in_array(basename($file),
                    $aImgFilesCatIcons) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
            ) {
                $artList = implode(', ', $error_notfound);
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('Obsolete File found: ' . $file);
                if (oxRegistry::getConfig()->getRequestParameter("autodelete")) {
                    unlink($file);
                }
            } else {
                $aFoundCatIcon[] = basename($file);
            }
        }
        $aNotFound = array_diff($aImgFilesCatIcons, $aFoundCatIcon);
        if (count($aNotFound) > 0) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay("Not found Icon in $imgdir :\n");
            foreach ($aNotFound as $notFoundItem) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay("- $notFoundItem \n");
            }
        }

        //Category Promo Icons
        $imgdir = $myConfig->getPictureDir(false) . 'master/category/promo_icon/';
        $aImgFilesCatPromo = Array();
        $aFoundCatPromo = Array();
        $sqlQuery4PromoIcons = "SELECT DISTINCT OXPROMOICON FROM oxcategories where OXPROMOICON!='';";
        $result = $oDb->getAll($sqlQuery4PromoIcons);
        foreach ($result as $row) {
            $aImgFilesCatPromo[] = $row['OXPROMOICON'];
        }

        $files = array_filter(glob($imgdir . '*'), 'is_file');
        foreach ($files as $file) {
            if (!in_array(basename($file),
                    $aImgFilesCatPromo) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
            ) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay('Obsolete File found: ' . $file);
                if (oxRegistry::getConfig()->getRequestParameter("autodelete")) {
                    unlink($file);
                }
            } else {
                $aFoundCatPromo[] = basename($file);
            }
        }
        $aNotFound = array_diff($aImgFilesCatPromo, $aFoundCatPromo);
        if (count($aNotFound) > 0) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay("Not found Promo-Icon in $imgdir :\n");
            foreach ($aNotFound as $notFoundItem) {
                oxRegistry::get("oxUtilsView")->addErrorToDisplay("- $notFoundItem \n");
            }
        }

    }
}
