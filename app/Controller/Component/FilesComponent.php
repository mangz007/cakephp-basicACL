<?php

class FilesComponent extends Component {

    var $dirs = array();

    function get($entity_type, $entity_id) {
        $file = ClassRegistry::init('File');
        return $file->find('all', array('conditions' => array('File.entity_type' => $entity_type, 'File.entity_id' => $entity_id)));
    }

    function save($data, $entity_type, $entity_id, $status = 1) {
// 	pr($data);
        $file = ClassRegistry::init('File');
        if (isset($data['File']) && count($data['File'])) {
            foreach ($data['File'] as $k => $v) {
                @mkdir(WWW_ROOT . "files/$k");
                @chmod(WWW_ROOT . "files/$k", 0777);
                foreach ($v as $vv) {
                    if($vv['size'] > 0 && $vv['error'] != 4){
                        $save_file_name = $this->_checkfilename($vv['name'], $k);
                        if (move_uploaded_file($vv['tmp_name'], WWW_ROOT . "files/$k/$save_file_name")) {
                            @chmod(WWW_ROOT . "files/$k/$save_file_name", 0777);
                            $file->create();
                            $file->save(array(
                                'entity_id' => $entity_id,
                                'entity_type' => $entity_type,
                                'file_name' => $save_file_name,
                                'status' => $status,
                                'folder' => trim($k),
                                'mime_type' => $vv['type']
                                    )
                            );
                        }
                    }
                }
            }
            return true;
        }
    }

    function changeStatus($id, $status = 1) {
        $file = ClassRegistry::init('File');
        $file->id = $id;
        if ($file->saveField('status', $status, false)) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id) {
        $file = ClassRegistry::init('File');
        $files = $file->findById($id);
        $folder = WWW_ROOT . "files/{$files['File']['folder']}";
        $file_name = $files['File']['file_name'];
        $folders = array();
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (is_dir("$folder/$entry")) {
                        $folders[] = "$folder/$entry";
                    }
                }
            }
            closedir($handle);
        }
        if (count($folders)) {
            foreach ($folders as $v) {
                @unlink("$v/$file_name");
            }
            @unlink("$folder/$file_name");
        }
        $file->id = $files['File']['id'];
        $file->delete();
        return true;
    }

    function _checkfilename($name, $folder) {
        $name = preg_replace("/\s/", "-", $name);
        if (file_exists(WWW_ROOT . "files/$folder/$name")) {
            $ext = substr(strrchr($name, '.'), 1);
            $c = preg_replace("/$ext/", "", $name);
            $file_name = substr($c, 0, -1);
            $separator = '-';
            $original_name = $file_name;
            $i = 0;
            do {
                // Append an incrementing numeric suffix until we find a unique alias.
                $unique_suffix = $separator . $i;
                $file_name = $original_name . $unique_suffix;
                $i++;
            } while (file_exists(WWW_ROOT . "files/$folder/$file_name.$ext"));
            return $file_name . "." . $ext;
        } else {
            return $name;
        }
    }

    function listdiraux($dir) {
        $handle = opendir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filepath = $dir == '.' ? $file : $dir . '/' . $file;
            if (is_link($filepath))
                continue;
            if (is_file($filepath))
                continue;
            else if (is_dir($filepath)) {
                $this->dirs[$filepath];
                $this->listdiraux($filepath);
            }
        }
        closedir($handle);
    }

    function save_single($data, $entity_type, $entity_id, $folder = '', $status = 1) {
// 	pr($data);
        $file = ClassRegistry::init('File');
        @mkdir(WWW_ROOT . "files/$folder");
        @chmod(WWW_ROOT . "files/$folder", 0777);
        if ($data['size'] > 0 && $data['error'] == 0) {
            $save_file_name = $this->_checkfilename($data['name'], $folder);
            if (move_uploaded_file($data['tmp_name'], WWW_ROOT . "files/$folder/$save_file_name")) {
                @chmod(WWW_ROOT . "files/$folder/$save_file_name", 0777);
                $file->create();
                $file->save(array(
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'file_name' => $save_file_name,
                    'status' => $status,
                    'folder' => trim($folder),
                    'mime_type' => $data['type']
                        )
                );
            }
        }
        return true;
    }

}

?>