<?php

namespace App\Repositories\Client;

use App\Models\Client;
use App\Models\Industry;

/**
 * Class ClientRepository.
 */
class ClientRepository implements ClientRepositoryContract
{
    const CREATED        = 'created';
    const UPDATED_ASSIGN = 'updated_assign';

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function listAllClients()
    {
        return Client::pluck('name', 'id');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getInvoices($id)
    {
        $invoice = Client::findOrFail($id)->invoices()->with('invoiceLines')->get();

        return $invoice;
    }

    /**
     * @return int
     */
    public function getAllClientsCount()
    {
        return Client::count();
    }

    /**
     * @return mixed
     */
    public function listAllIndustries()
    {
        return Industry::pluck('name', 'id');
    }

    /**
     * @param $requestData
     */
    public function create($requestData)
    {
        $filename = null;
        if ($requestData->hasFile('signature_path')) {
            if (!is_dir(public_path(). '/upload/')) {
                mkdir(public_path(). '/upload/', 0777, true);
            }
            $file =  $requestData->file('signature_path');

            $destinationPath = public_path(). '/upload/';
            $filename = str_random(8) . '_' . $file->getClientOriginalName() ;
            $file->move($destinationPath, $filename);
        }
        $requestData = array_merge(
            $requestData->all(),
            ['signature_path' => $filename,]
        );

        $client = Client::create($requestData);
        Session()->flash('flash_message', 'Client successfully added');
        //event(new \App\Events\ClientAction($client, self::CREATED));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function update($id, $requestData)
    {
        $client = Client::findOrFail($id);
        $client->fill($requestData->all())->save();
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        try {
            $client = Client::findorFail($id);
            $client->delete();
            Session()->flash('flash_message', 'Client successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            Session()->flash('flash_message_warning', 'Client can NOT have, leads, or tasks assigned when deleted');
        }
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateAssign($id, $requestData)
    {
        $client          = Client::with('user')->findOrFail($id);
        $client->user_id = $requestData->get('user_assigned_id');
        $client->save();

        event(new \App\Events\ClientAction($client, self::UPDATED_ASSIGN));
    }

    /**
     * @param $requestData
     *
     * @return string
     */
    public function vat($requestData)
    {
        $vat = $requestData->input('vat');

        $country      = $requestData->input('country');
        $name         = $requestData->input('name');

        // Strip all other characters than numbers
        $vat = preg_replace('/[^0-9]/', '', $vat);

        function cvrApi($vat)
        {
            if (empty($vat)) {
                // Print error message
                return 'Please insert VAT';
            } else {
                // Start cURL
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, 'http://cvrapi.dk/api?search='.$vat.'&country=dk');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Flashpoint');

                // Parse result
                $result = curl_exec($ch);

                // Close connection when done
                curl_close($ch);

                // Return our decoded result
                return json_decode($result, 1);
            }
        }

        $result = cvrApi($vat, 'dk');

        return $result;
    }
}
