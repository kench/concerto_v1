<G?php


function init_db( ) {    
    mysql_pconnect("studentsenate.rpi.edu", "signage", "216719")
        or die("MySQL connect failed! error = " . mysql_error( ));
    mysql_select_db("signage_hardware")
        or die("MySQL select database failed: " . mysql_error( ));
}

function validate_mac($mac) {
    if (preg_match('/^[0-9A-Fa-f]{12}$/', $mac)) {
        return 1;
    } else {
        return 0;
    }
}

class HardwareClass {
    public function create_new($name) {
        // create a new hardware class and return it.
        // escape the string first in case it contains special chars
        $name = mysql_escape_string($name);
        mysql_query("insert into class (name) values(\"$name\")")
            or die("query to create new class failed: " . mysql_error( ));
        $new_id = mysql_insert_id( );
        return HardwareClass::load_from_id($new_id);
    }
    public function load_all_from_db( ) {
        // load all classes from the database
        $result = mysql_query("select class_id from class")
            or die("query to load class list failed: " . mysql_error( ));
        
        $objs = array( );
        while ($row = mysql_fetch_row($result)) {
            array_push($objs, HardwareClass::load_from_id($row[0]));
        }

        return $objs;
    }

    public function load_from_id($id) {
        // load a hardware class from the database given its ID
        $obj = new HardwareClass( );
        if (!is_numeric($id)) {
            die("passed non-numeric ID to load_from_id");
        }
        
        $result = mysql_query("select name from class where class_id=$id")
            or die("query to load ID failed: " . mysql_error( ));
        
        if (!($row = mysql_fetch_row($result))) {
            die("attempt to load nonexistent class $id");
        } else {
            $obj->id = $id;
            $obj->name = $row[0];
            return $obj;
        }
    }

    public function get_member_list( ) {
        // load the list of member MAC addresses from the database
        // returns an array of MAC strings
        $id = $this->id;
        $result = mysql_query("select mac from class_map where class_id=$id")
            or die("query to load member list failed: " . mysql_error( ));

        $ret = array( );

        while ($row = mysql_fetch_row($result)) {
           array_push($ret, $row[0]);
        }
        return $ret;
    }

    public function add_member($mac) {
        // add the machine specified by $mac to the database
        // also this will remove it from any other class
        $id = $this->id;
        # match against a regex
        if (!validate_mac($mac)) {
            die("Error: input is not a valid MAC address");
        }
        $mac = mysql_escape_string($mac);
        mysql_query("delete from class_map where mac=\"$mac\"")
            or die("query to remove class member failed: " . mysql_error( ));
        mysql_query("insert into class_map(class_id, mac) values($id, \"$mac\")") 
            or die("query to add class member failed: " . mysql_error( ));
    }
    
    public function rename($new_name) {
        // rename the class
        $id = $this->id;
        $new_name = mysql_escape_string($new_name);
        mysql_query("update class set name=\"$new_name\" where class_id=$id")
            or die("query to rename class failed: " . mysql_error( ));
        $this->name = $new_name;
    }

    public function remove( ) {
        // remove the class (all machines will go to the default class 1)

        if ($this->id == 1) {
            die("attempt to remove the default class (class 1)!");
        }

        $id = $this->id;

        // move everyone to class 1
        mysql_query("update class_map set class_id=1 where class_id=$id")
            or die("query to move to class 1 failed: " . mysql_error( ));

        mysql_query("delete from class where class_id=$id")
            or die("query to delete class $id failed: " . mysql_error( ));
    }

    public function remove_member($mac) {
        $id = $this->id;
        if (!validate_mac($mac)) {
            die("invalid MAC passed to HardwareClass::remove_member");
        }
        $mac = mysql_escape_string($mac);

        mysql_query("delete from class_map where class_id=$id and mac='$mac'")
            or die("query to delete member $mac from class $id failed:"
                . mysql_error( ));
    }

    public function get_id( ) {
        return $this->id;
    }
    public function get_name( ) {
        return $this->name;
    }

    public function add_override($path) {
        
    }

    public function remove_override($path) {

    }

    public function edit_override($path, $new_text) {

    }

    private $id;
    private $name;


}

?>

