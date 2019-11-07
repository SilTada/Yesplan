# Yesplan

## Load

load.php will perform a require_once for all necessary files in the lib-folder.

## Create a client object

This step is crutial all the other functions to work.

    $client = new Yesplan\Client(YESPLAN_DOMAIN, YESPLAN_API_KEY);

Where YESPLAN_DOMAIN should be your Yespan domain, without *http://* and trailing *.yesplan.be*. If your domain is http://rockit.yesplan.be, **rockit** should be your domain.

YESPLAN API key should be a valid key, generated by your Yesplan install.

## Endpoints

For getting data we're using the same method for all edpoints. Note: not all available endpoints in the Yesplan API are yet available in this repository. If you'd like to use an endpoint which is nog included, you can use the Url endpoint.

### Url

    Yesplan\Endpoints\Url::get($client, $full_request_url_without_api_key);

### Events 

#### getList

This function will give a list of events for a given [Yesplan search query](https://manual.yesplan.be/en/query-language/).

    Yesplan\Endpoints\Events::getList($client, $searchquery);

#### get

Get all data from an event.

    Yesplan\Endpoints\Events::get($client, $id);

#### getSchedule

Get schedule data from an event.

    Yesplan\Endpoints\Events::getSchedule($client, $id);

#### getAttachments

Get all attachments from an event.

    Yesplan\Endpoints\Events::getAttachments($client, $id);

#### getCustomdata

Get custom data from an event.

    Yesplan\Endpoints\Events::getCustomdata($client, $id, $keywords);

Where $keywords can either be an array or a list of komma separated Yesplan keywords.

#### customdataByKey

Creates a new object with given custom data object where data is sorted by keyword. This way it's easier to get custom data values.

    Yesplan\Endpoints\Events::customdataByKey($customdata);
    
##### Output example

**getCustomdata** will output somthing like this:

    Array
    (
        [0] => stdClass Object
            (
                [name] => Titel
                [keyword] => production_title
                [type] => String
                [value] => Exil
            )

        [1] => stdClass Object
            (
                [name] => Uitvoerder
                [keyword] => production_performer
                [type] => String
                [value] => Axelle Red
            )

    )

After running this through the **customdataByKey** function you'll get something like this.

    stdClass Object
    (
        [production_title] => Exil
        [production_performer] => Axelle Red
    )






















To be continued...