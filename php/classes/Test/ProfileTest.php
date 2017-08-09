<?php
namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{Profile};

// grab the class
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class
 * It is complete because *ALL* MySQL\PDO enabled methods are tested for both invalid and valid inputs
 *
 * @see Profile
 * @author Jack Reuter <djreuter45@gmail.com>
 */
class ProfileTest extends DeepDiveTutorTest {
	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME = "John Smith";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_EMAIL = "test@phpunit.de";

	/**
	 * valid profile type (student)
	 * @var int $VALID_TYPE_S
	 */
	protected $VALID_TYPE_S = 0;

	/**
	 * valid profile type (tutor)
	 * @var int $VALID_TYPE_T
	 */
	protected $VALID_TYPE_T = 1;

	/**
	 * valid profile github token
	 * @var $VALID_GITHUBTOKEN
	 */
	protected $VALID_GITHUBTOKEN = "Loremipsumdolorsitametconsecteturadipiscingelitposuerefhdrtuiseb";

	/**
	 * valid profile bio
	 * @var string $VALID_BIO
	 */
	protected $VALID_BIO = "This is a bio";

	/**
	 * valid profile rate
	 * @var float $VALID_RATE
	 */
	protected $VALID_RATE = 25.00;

	/**
	 * valid profile image
	 * @var $VALID_IMAGE
	 */
	protected $VALID_IMAGE = "Loremipsdolorsitametconthirtytwo";

	/**
	 * valid last edit date time
	 * @var $VALID_DATETIME
	 */
	protected $VALID_DATETIME = null;

	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid salt to use
	 * @var $VALID_SALT
	 */
	protected $VALID_SALT;



	/**
	 * run the default operation to create the salt and hash
	 */
	public final function setUp(): void {
		// refer to name of the base class as given in the extends declaration of this class
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and verify that the actual MySQL data matches
	 */
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
	$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
		$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
		$this->VALID_HASH, $this->VALID_SALT);

		// var_dump($profile);

		$profile->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match out expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProfile(): void {
		// create a profile with a non null profileId and watch it fail
		$profile = new Profile(DeepDiveTutorTest::INVALID_KEY, $this->VALID_NAME, $this->VALID_EMAIL,
			$this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN, $this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE,
			$this->VALID_DATETIME, $this->VALID_ACTIVATION, $this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 */



}