<?php

function find_all_persons() {
	global $db;

	$sql = "SELECT * FROM person ";
	$sql .= "ORDER BY last_name ASC";
	//echo $sql;
	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );
	return $result;
}

//defaults to getting people created today
//0 - get users created today
//1 - get users created in past week
//2 - get users created in past month
function find_persons_created_on($options=0){
    global $db;

    if($options == 0) {
        $sql = "SELECT *, DATE_FORMAT(created_on, '%Y-%m-%d') ";
        $sql .= "FROM person ";
        $sql .= "WHERE DATE(created_on) = CURDATE()";
    }elseif($options == 1){
        $sql = "SELECT * FROM person ";
        $sql .= "WHERE YEARWEEK(created_on, 1) = YEARWEEK(CURDATE(), 1)";
    }elseif($options == 2){
        $sql = "SELECT * FROM person ";
        $sql .= "WHERE YEARWEEK(created_on, 1) = YEARWEEK(CURDATE(), 1)";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_all_posts() {
	global $db;

	$sql = "SELECT * FROM post, person ";
	$sql .= "WHERE post.person_id = person.person_id ";
	$sql .= "ORDER BY datetime_posted DESC";
	//echo $sql;
	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );
	return $result;
}

function find_posts_by_person($person_id){
	global $db;
	$sql = "SELECT * FROM post ";
	$sql .= "WHERE person_id='" . db_escape( $db, $person_id ) . "' ";
	$sql .= "ORDER BY datetime_posted DESC ";

	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );

	return $result; // returns an assoc. array
}

function find_person_by_email( $email ) {
    global $db;

    $sql = "SELECT * FROM person ";
    $sql .= "WHERE email='" . db_escape( $db, $email ) . "'";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    $person = mysqli_fetch_assoc( $result );
    mysqli_free_result( $result );
    return $person; // returns an assoc. array
}

function find_admin_by_email( $email ) {
    global $db;

    $sql = "SELECT * FROM person ";
    $sql .= "WHERE email='" . db_escape( $db, $email ) . "' ";
    $sql .= "AND is_admin='1' ";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    $person = mysqli_fetch_assoc( $result );
    mysqli_free_result( $result );
    return $person; // returns an assoc. array
}

function find_all_organizations() {
	global $db;

	$sql = "SELECT * FROM organization ";
	$sql .= "ORDER BY created_on ASC";

	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );

	return $result;
}

function find_person_by_id( $person_id ) {
	global $db;

	$sql = "SELECT * FROM person ";
	$sql .= "WHERE person_id='" . db_escape( $db, $person_id ) . "'";
	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );
	$person = mysqli_fetch_assoc( $result );
	mysqli_free_result( $result );
	return $person; // returns an assoc. array
}

function find_post_by_id( $post_id ) {
	global $db;

	$sql = "SELECT * FROM post, person ";
	$sql .= "WHERE post_id='" . db_escape( $db, $post_id ) . "' ";
	$sql .= "AND post.person_id=person.person_id ";
	$result = mysqli_query( $db, $sql );
	confirm_result_set( $result );
	$post = mysqli_fetch_assoc( $result );
	mysqli_free_result( $result );
	return $post; // returns an assoc. array
}

function validate_avatar($file_data){
    $errors = [];
    $valid_extensions = ['jpeg','jpg','png','gif'];
    $size_limit = 10000000;

    //if(is_blank($person['profile_pic']['name'])){
    //   $errors['file_name'] = "Avatar cannot be blank.";
    //}
    if(!is_valid_file_extension($file_data['extension'], $valid_extensions)){
        $errors['file_extension'] = "Invalid file type.";
    }

    if(!is_valid_upload_size($file_data['size'], $size_limit)){
        $errors['file_size'] = "File size must be less than or equal to " . ($size_limit / 1000 / 1000) . "MB.";
    }

    return $errors;
}

function validate_person( $person, $options=[] ) {
	$errors = [];

	$password_required = $options['password_required'] ?? true;

	// first_name
	if ( is_blank( $person[ 'first_name' ] ) ) {
		$errors[ 'first_name' ] = "First Name cannot be blank.";
	} elseif ( !has_length( $person[ 'first_name' ], [ 'min' => 2, 'max' => 255 ] ) ) {
		$errors[ 'first_name' ] = "First Name must be between 2 and 255 characters.";
	}

	// last_name
	if ( is_blank( $person[ 'last_name' ] ) ) {
		$errors[ 'last_name' ] = "Last Name cannot be blank.";
	} elseif ( !has_length( $person[ 'last_name' ], [ 'min' => 2, 'max' => 255 ] ) ) {
		$errors[ 'last_name' ] = "Last Name must be between 2 and 255 characters.";
	}

	//email
	if ( is_blank( $person[ 'email' ] ) ) {
		$errors[ 'email' ] = "Email cannot be blank.";
	} elseif ( !has_valid_email_format( $person[ 'email' ] ) ) {
		$errors[ 'email' ] = "Invalid email format.";
	}

	//password
    //if checks to not require a password when updating a person record
    if($password_required) {
        if (is_blank($person['password'])) {
            $errors['password'] = "Password cannot be blank.";
        } elseif (!has_length($person['password'], ['min' => 2, 'max' => 255])) {
            $errors['password'] = "Password must be between 2 and 255 characters.";
        }
    }
	//created on
	if ( is_blank( $person[ 'created_on' ] ) ) {
		$errors[ 'created_on' ] = "Created on cannot be blank.";
	}

	//birth_date
	if ( is_date_default( $person[ 'birth_date' ] ) ) {
		$errors[ 'birth_date' ] = "Please enter a valid birth date.";
	}

	return $errors;
}

function validate_post( $post ) {
	$errors = [];

	// content
	if ( is_blank( $post[ 'content' ] ) ) {
		$errors[ 'content' ] = "Content cannot be blank.";
	}

	return $errors;
}

function insert_person( $person ) {
	global $db;

	$errors = validate_person( $person );
	if ( !empty( $errors ) ) {
		return $errors;
	}

	$hashed_password = password_hash($person['password'], PASSWORD_DEFAULT);

	$sql = "INSERT INTO person ";
	$sql .= "(first_name, last_name, email, password, is_premium, is_admin, profile_pic, birth_date, biography) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape( $db, $person[ 'first_name' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'last_name' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'email' ] ) . "',";
	$sql .= "'" . db_escape( $db, $hashed_password ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'is_premium' ] ) . "',";
	//$sql .= "'" . db_escape( $db, $person[ 'created_on' ] ) . "',";
	//$sql .= "'" . db_escape( $db, $person[ 'updated_on' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'is_admin' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'profile_pic' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'birth_date' ] ) . "',";
	$sql .= "'" . db_escape( $db, $person[ 'biography' ] ) . "'";
	$sql .= ")";
	$result = mysqli_query( $db, $sql );
	// For INSERT statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// INSERT failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

function update_person( $person ) {
	global $db;

	$password_sent = !is_blank($person['password']);

	$errors = validate_person( $person, ['password_required' => $password_sent]);
	if ( !empty( $errors ) ) {
		return $errors;
	}

    $hashed_password = password_hash($person['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE person SET ";
	$sql .= "first_name='" . db_escape($db, $person['first_name']) . "', ";
	$sql .= "last_name='" . db_escape($db, $person['last_name']) . "', ";
	$sql .= "email='" . db_escape($db, $person['email']) . "', ";
	if($password_sent){
        $sql .= "password='" . db_escape($db, $hashed_password) . "', ";
    }
	$sql .= "is_premium='" . db_escape($db, $person['is_premium']) . "', ";
	$sql .= "birth_date='" . db_escape($db, $person['birth_date']) . "', ";
	$sql .= "biography='" . db_escape($db, $person['biography']) . "', ";
	$sql .= "is_admin='" . db_escape($db, $person['is_admin']) . "' ";
	$sql .= "WHERE person_id='" . db_escape($db, $person['person_id']) . "' ";
	$sql .= "LIMIT 1";
	
	$result = mysqli_query( $db, $sql );
	// For UPDATE statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// UPDATE failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

function update_avatar( $person, $file_data){
    global $db;

    $errors = validate_avatar( $file_data );

    if ( !empty( $errors ) ) {
        return $errors;
    }



    $sql = "UPDATE person SET ";
    $sql .= "profile_pic='" . db_escape($db, ltrim($file_data['path'], '/')) . "' ";
    $sql .= "WHERE person_id='" . db_escape($db, $person['person_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query( $db, $sql );
    // For UPDATE statements, $result is true/false
    if ( $result ) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error( $db );
        db_disconnect( $db );
        exit;
    }
}

function delete_person( $person_id ) {
	global $db;

	$sql = "DELETE FROM person ";
	$sql .= "WHERE person_id='" . db_escape( $db, $person_id ) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query( $db, $sql );

	// For DELETE statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// DELETE failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

function delete_post( $post_id ) {
	global $db;

	$sql = "DELETE FROM post ";
	$sql .= "WHERE post_id='" . db_escape( $db, $post_id ) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query( $db, $sql );

	// For DELETE statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// DELETE failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

function delete_post_by_post_id_and_person_id( $post_id, $person_id ) {
    global $db;

    $sql = "DELETE FROM post ";
    $sql .= "WHERE post_id='" . db_escape( $db, $post_id ) . "' ";
    $sql .= "AND person_id='" . db_escape($db, $person_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query( $db, $sql );

    // For DELETE statements, $result is true/false
    if ( $result ) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error( $db );
        db_disconnect( $db );
        exit;
    }
}

function insert_post( $post ) {
	global $db;

	$errors = validate_post( $post );
	if ( !empty( $errors ) ) {
		return $errors;
	}

	$sql = "INSERT INTO post ";
	$sql .= "(person_id, content) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape( $db, $post[ 'person_id' ] ) . "',";
	$sql .= "'" . db_escape( $db, $post[ 'content' ] ) . "'";
	$sql .= ")";
	$result = mysqli_query( $db, $sql );
	// For INSERT statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// INSERT failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

function update_post( $post ) {
	global $db;

	$errors = validate_post( $post );
	if ( !empty( $errors ) ) {
		return $errors;
	}

	$sql = "UPDATE post SET ";
	$sql .= "person_id='" . db_escape($db, $post['person_id']) . "', ";
	$sql .= "content='" . db_escape($db, $post['content']) . "' ";
	$sql .= "WHERE post_id='" . db_escape($db, $post['post_id']) . "' ";
	$sql .= "LIMIT 1";
	
	$result = mysqli_query( $db, $sql );
	// For UPDATE statements, $result is true/false
	if ( $result ) {
		return true;
	} else {
		// UPDATE failed
		echo mysqli_error( $db );
		db_disconnect( $db );
		exit;
	}
}

?>