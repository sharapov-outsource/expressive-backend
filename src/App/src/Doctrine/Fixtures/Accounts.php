<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 29.12.2019
 * Time: 23:49
 */

declare(strict_types=1);

namespace App\Doctrine\Fixtures;

use App\Entity\Account;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Accounts implements FixtureInterface
{
    public $accounts = [
        [
            "firstName" => "Christal",
            "lastName" => "Sinkins",
            "birthDate" => "11/1/1966",
            "gender" => "Female",
            "avatar" => "https://robohash.org/doloremquedebitisatque.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "North Carolina",
            "city" => "Raleigh",
            "zipCode" => "27658"
        ],
        [
            "firstName" => "Carlin",
            "lastName" => "Brehault",
            "birthDate" => "7/4/1976",
            "gender" => "Male",
            "avatar" => "https://robohash.org/deseruntliberoin.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "San Antonio",
            "zipCode" => "78225"
        ],
        [
            "firstName" => "Hal",
            "lastName" => "Eddisforth",
            "birthDate" => "9/6/1955",
            "gender" => "Male",
            "avatar" => "https://robohash.org/oditdistinctioconsequatur.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "San Antonio",
            "zipCode" => "78278"
        ],
        [
            "firstName" => "Lamond",
            "lastName" => "Gowland",
            "birthDate" => "6/18/1982",
            "gender" => "Male",
            "avatar" => "https://robohash.org/omnisvoluptatibussit.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "California",
            "city" => "Van Nuys",
            "zipCode" => "91411"
        ],
        [
            "firstName" => "Nana",
            "lastName" => "Gilliver",
            "birthDate" => "7/5/1973",
            "gender" => "Female",
            "avatar" => "https://robohash.org/beataesuntsoluta.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Missouri",
            "city" => "Kansas City",
            "zipCode" => "64144"
        ],
        [
            "firstName" => "Ninnette",
            "lastName" => "Ivell",
            "birthDate" => "11/22/1957",
            "gender" => "Female",
            "avatar" => "https://robohash.org/autnonillo.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Virginia",
            "city" => "Roanoke",
            "zipCode" => "24029"
        ],
        [
            "firstName" => "Vidovic",
            "lastName" => "Romaines",
            "birthDate" => "12/14/1972",
            "gender" => "Male",
            "avatar" => "https://robohash.org/namestcumque.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "Dallas",
            "zipCode" => "75310"
        ],
        [
            "firstName" => "Brnaby",
            "lastName" => "Feare",
            "birthDate" => "8/25/1974",
            "gender" => "Male",
            "avatar" => "https://robohash.org/perspiciatisconsequaturet.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "California",
            "city" => "Sacramento",
            "zipCode" => "95813"
        ],
        [
            "firstName" => "Palmer",
            "lastName" => "Worsalls",
            "birthDate" => "3/22/1953",
            "gender" => "Male",
            "avatar" => "https://robohash.org/fugaatqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "North Carolina",
            "city" => "Fayetteville",
            "zipCode" => "28314"
        ],
        [
            "firstName" => "Deny",
            "lastName" => "Greenland",
            "birthDate" => "11/11/1958",
            "gender" => "Female",
            "avatar" => "https://robohash.org/idnamvelit.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Kansas",
            "city" => "Shawnee Mission",
            "zipCode" => "66220"
        ],
        [
            "firstName" => "Rhetta",
            "lastName" => "Baudon",
            "birthDate" => "3/22/1964",
            "gender" => "Female",
            "avatar" => "https://robohash.org/fugitquianisi.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Missouri",
            "city" => "Kansas City",
            "zipCode" => "64179"
        ],
        [
            "firstName" => "Padget",
            "lastName" => "Broggini",
            "birthDate" => "1/21/1982",
            "gender" => "Male",
            "avatar" => "https://robohash.org/nonnobisqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Missouri",
            "city" => "Columbia",
            "zipCode" => "65218"
        ],
        [
            "firstName" => "Dorthea",
            "lastName" => "McKinie",
            "birthDate" => "6/13/1984",
            "gender" => "Female",
            "avatar" => "https://robohash.org/eautexercitationem.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Alabama",
            "city" => "Birmingham",
            "zipCode" => "35220"
        ],
        [
            "firstName" => "Brigitte",
            "lastName" => "Havvock",
            "birthDate" => "6/16/1977",
            "gender" => "Female",
            "avatar" => "https://robohash.org/doloreeumqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Rhode Island",
            "city" => "Providence",
            "zipCode" => "02912"
        ],
        [
            "firstName" => "Linnet",
            "lastName" => "Pumphrey",
            "birthDate" => "12/21/1982",
            "gender" => "Female",
            "avatar" => "https://robohash.org/atquesitminima.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Arizona",
            "city" => "Tucson",
            "zipCode" => "85720"
        ],
        [
            "firstName" => "Jens",
            "lastName" => "Courtney",
            "birthDate" => "8/27/1960",
            "gender" => "Male",
            "avatar" => "https://robohash.org/eosdebitisneque.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Kentucky",
            "city" => "Lexington",
            "zipCode" => "40576"
        ],
        [
            "firstName" => "Dav",
            "lastName" => "Massey",
            "birthDate" => "11/2/1983",
            "gender" => "Male",
            "avatar" => "https://robohash.org/facerequiprovident.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "North Carolina",
            "city" => "Winston Salem",
            "zipCode" => "27150"
        ],
        [
            "firstName" => "Lorianne",
            "lastName" => "Comettoi",
            "birthDate" => "8/31/1974",
            "gender" => "Female",
            "avatar" => "https://robohash.org/delenitiquasest.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Kentucky",
            "city" => "Louisville",
            "zipCode" => "40250"
        ],
        [
            "firstName" => "Dagmar",
            "lastName" => "Jenney",
            "birthDate" => "3/1/1966",
            "gender" => "Female",
            "avatar" => "https://robohash.org/ducimusetnobis.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "New York",
            "city" => "New York City",
            "zipCode" => "10019"
        ],
        [
            "firstName" => "Halsey",
            "lastName" => "Bugbee",
            "birthDate" => "8/16/1957",
            "gender" => "Male",
            "avatar" => "https://robohash.org/laborequioccaecati.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "Austin",
            "zipCode" => "78789"
        ],
        [
            "firstName" => "Maurizia",
            "lastName" => "O'Heagertie",
            "birthDate" => "10/10/1972",
            "gender" => "Female",
            "avatar" => "https://robohash.org/autemdoloribuspariatur.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "Orlando",
            "zipCode" => "32859"
        ],
        [
            "firstName" => "Morissa",
            "lastName" => "McKerton",
            "birthDate" => "5/17/1975",
            "gender" => "Female",
            "avatar" => "https://robohash.org/perspiciatisvelitquaerat.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "South Carolina",
            "city" => "Charleston",
            "zipCode" => "29403"
        ],
        [
            "firstName" => "Philip",
            "lastName" => "Heers",
            "birthDate" => "12/7/1971",
            "gender" => "Male",
            "avatar" => "https://robohash.org/debitisoccaecatised.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "West Palm Beach",
            "zipCode" => "33416"
        ],
        [
            "firstName" => "Pail",
            "lastName" => "Troni",
            "birthDate" => "4/30/1960",
            "gender" => "Male",
            "avatar" => "https://robohash.org/enimetqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Illinois",
            "city" => "Chicago",
            "zipCode" => "60657"
        ],
        [
            "firstName" => "Cody",
            "lastName" => "Berndt",
            "birthDate" => "5/8/1971",
            "gender" => "Female",
            "avatar" => "https://robohash.org/sitquiaprovident.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Kansas",
            "city" => "Shawnee Mission",
            "zipCode" => "66276"
        ],
        [
            "firstName" => "Gipsy",
            "lastName" => "Sterre",
            "birthDate" => "12/26/1971",
            "gender" => "Female",
            "avatar" => "https://robohash.org/quamsintest.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "Jacksonville",
            "zipCode" => "32236"
        ],
        [
            "firstName" => "Fred",
            "lastName" => "Caine",
            "birthDate" => "10/14/1967",
            "gender" => "Male",
            "avatar" => "https://robohash.org/quidemmolestiaecum.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "North Carolina",
            "city" => "Charlotte",
            "zipCode" => "28278"
        ],
        [
            "firstName" => "Minda",
            "lastName" => "Salleir",
            "birthDate" => "12/28/1978",
            "gender" => "Female",
            "avatar" => "https://robohash.org/voluptateoditid.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Utah",
            "city" => "Provo",
            "zipCode" => "84605"
        ],
        [
            "firstName" => "Ted",
            "lastName" => "Gagg",
            "birthDate" => "3/26/1956",
            "gender" => "Male",
            "avatar" => "https://robohash.org/estquidemet.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Oklahoma",
            "city" => "Tulsa",
            "zipCode" => "74103"
        ],
        [
            "firstName" => "Mercie",
            "lastName" => "Klima",
            "birthDate" => "6/27/1955",
            "gender" => "Female",
            "avatar" => "https://robohash.org/dignissimosoptiorerum.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "Orlando",
            "zipCode" => "32830"
        ],
        [
            "firstName" => "Grove",
            "lastName" => "Spinney",
            "birthDate" => "9/4/1969",
            "gender" => "Male",
            "avatar" => "https://robohash.org/perferendisnatuseos.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Michigan",
            "city" => "Lansing",
            "zipCode" => "48930"
        ],
        [
            "firstName" => "Ced",
            "lastName" => "Mc Faul",
            "birthDate" => "3/25/1955",
            "gender" => "Male",
            "avatar" => "https://robohash.org/errordoloribusest.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "El Paso",
            "zipCode" => "79940"
        ],
        [
            "firstName" => "Nico",
            "lastName" => "Elstone",
            "birthDate" => "7/7/1962",
            "gender" => "Male",
            "avatar" => "https://robohash.org/etilloarchitecto.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "California",
            "city" => "San Diego",
            "zipCode" => "92115"
        ],
        [
            "firstName" => "Gael",
            "lastName" => "Nystrom",
            "birthDate" => "3/20/1976",
            "gender" => "Male",
            "avatar" => "https://robohash.org/consecteturdignissimosquasi.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Massachusetts",
            "city" => "Brockton",
            "zipCode" => "02405"
        ],
        [
            "firstName" => "Alexei",
            "lastName" => "Giovannilli",
            "birthDate" => "3/3/1983",
            "gender" => "Male",
            "avatar" => "https://robohash.org/aspernaturporrosit.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Tennessee",
            "city" => "Murfreesboro",
            "zipCode" => "37131"
        ],
        [
            "firstName" => "Der",
            "lastName" => "Febre",
            "birthDate" => "3/5/1953",
            "gender" => "Male",
            "avatar" => "https://robohash.org/quianon.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "New York",
            "city" => "New York City",
            "zipCode" => "10019"
        ],
        [
            "firstName" => "Fran",
            "lastName" => "Plewright",
            "birthDate" => "6/16/1984",
            "gender" => "Female",
            "avatar" => "https://robohash.org/excepturivoluptasrerum.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "Jacksonville",
            "zipCode" => "32236"
        ],
        [
            "firstName" => "Ethelin",
            "lastName" => "Carss",
            "birthDate" => "7/27/1962",
            "gender" => "Female",
            "avatar" => "https://robohash.org/teneturfacilisvoluptas.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Ohio",
            "city" => "Toledo",
            "zipCode" => "43605"
        ],
        [
            "firstName" => "Nikos",
            "lastName" => "Boniface",
            "birthDate" => "5/21/1958",
            "gender" => "Male",
            "avatar" => "https://robohash.org/fugaquiaqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Maryland",
            "city" => "Laurel",
            "zipCode" => "20709"
        ],
        [
            "firstName" => "Webb",
            "lastName" => "Offin",
            "birthDate" => "11/22/1961",
            "gender" => "Male",
            "avatar" => "https://robohash.org/voluptatesautemullam.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Florida",
            "city" => "Orlando",
            "zipCode" => "32854"
        ],
        [
            "firstName" => "Nevins",
            "lastName" => "Tomisch",
            "birthDate" => "3/24/1981",
            "gender" => "Male",
            "avatar" => "https://robohash.org/quoipsameos.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Alabama",
            "city" => "Huntsville",
            "zipCode" => "35895"
        ],
        [
            "firstName" => "Jonathan",
            "lastName" => "McSporon",
            "birthDate" => "6/26/1961",
            "gender" => "Male",
            "avatar" => "https://robohash.org/atdoloremquepraesentium.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "New York",
            "city" => "Brooklyn",
            "zipCode" => "11236"
        ],
        [
            "firstName" => "Milicent",
            "lastName" => "Carbin",
            "birthDate" => "9/19/1970",
            "gender" => "Female",
            "avatar" => "https://robohash.org/quasiquasomnis.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Nebraska",
            "city" => "Omaha",
            "zipCode" => "68110"
        ],
        [
            "firstName" => "Riannon",
            "lastName" => "Greenacre",
            "birthDate" => "11/6/1962",
            "gender" => "Female",
            "avatar" => "https://robohash.org/esseveldoloremque.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "California",
            "city" => "San Diego",
            "zipCode" => "92105"
        ],
        [
            "firstName" => "Krystyna",
            "lastName" => "Randalston",
            "birthDate" => "11/11/1962",
            "gender" => "Female",
            "avatar" => "https://robohash.org/rationedignissimoseos.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Texas",
            "city" => "San Antonio",
            "zipCode" => "78291"
        ],
        [
            "firstName" => "Colan",
            "lastName" => "McPhelimy",
            "birthDate" => "9/3/1958",
            "gender" => "Male",
            "avatar" => "https://robohash.org/velitodioveniam.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Ohio",
            "city" => "Columbus",
            "zipCode" => "43231"
        ],
        [
            "firstName" => "Stillmann",
            "lastName" => "Tejada",
            "birthDate" => "6/19/1965",
            "gender" => "Male",
            "avatar" => "https://robohash.org/doloresvoluptasvel.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Wisconsin",
            "city" => "Madison",
            "zipCode" => "53785"
        ],
        [
            "firstName" => "Trescha",
            "lastName" => "Oxterby",
            "birthDate" => "6/22/1956",
            "gender" => "Female",
            "avatar" => "https://robohash.org/temporibustotamillo.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Virginia",
            "city" => "Richmond",
            "zipCode" => "23285"
        ],
        [
            "firstName" => "Lyndel",
            "lastName" => "Robottom",
            "birthDate" => "5/8/1975",
            "gender" => "Female",
            "avatar" => "https://robohash.org/exercitationemvelrepudiandae.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Arkansas",
            "city" => "Fort Smith",
            "zipCode" => "72916"
        ],
        [
            "firstName" => "Rowney",
            "lastName" => "Salsbury",
            "birthDate" => "10/16/1971",
            "gender" => "Male",
            "avatar" => "https://robohash.org/exlaboriosamqui.jpg?size=48x48&set=set1",
            "country" => "United States",
            "state" => "Arkansas",
            "city" => "Little Rock",
            "zipCode" => "72231"
        ]
    ];

    public static $defaultPassword = '123456';

    public function load(ObjectManager $manager)
    {
        $accountRoleCollection = $manager
            ->getRepository(Account\AccountRoleEntity::class)
            ->findAll();

        $randAccounts = array_rand($this->accounts, 4);

        foreach ($accountRoleCollection as $accountRole) {
            /** @var Account\AccountRoleEntity $accountRole */
            $username = sprintf('%s@bixpressive.com', $accountRole->getKey());

            $accountData = $this->accounts[array_shift($randAccounts)];

            $accountOptionCollection = [
                (new Account\AccountOptionEntity())->setOptionPersonal('firstName', $accountData['firstName'], true),
                (new Account\AccountOptionEntity())->setOptionPersonal('lastName', $accountData['lastName'], true),
                (new Account\AccountOptionEntity())->setOptionPersonal('birthDate', $accountData['birthDate'], true),
                (new Account\AccountOptionEntity())->setOptionPersonal('gender', $accountData['gender'], true),
                (new Account\AccountOptionEntity())->setOptionPersonal('avatar', $accountData['avatar'], true),
                (new Account\AccountOptionEntity())->setOptionAddress('country', $accountData['country']),
                (new Account\AccountOptionEntity())->setOptionAddress('state', $accountData['state']),
                (new Account\AccountOptionEntity())->setOptionAddress('city', $accountData['city']),
                (new Account\AccountOptionEntity())->setOptionAddress('zipCode', $accountData['zipCode'])
            ];

            $userAccount = new Account\AccountEntity();
            $userAccount
                ->setUsername($username)
                ->setPassword(md5(self::$defaultPassword))
                ->setStatus(1)
                ->setAccountRole($accountRole)
                ->setIsActivated(1)
                ->setAccountOption(new ArrayCollection($accountOptionCollection));
            $manager->persist($userAccount);
        }
        $manager->flush();
    }
}
