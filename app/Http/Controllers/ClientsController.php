<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    // The required CSV header format
    private $headerFormat = [
        0 => "id",
        1 => "name",
        2 => "url",
        3 => "logo",
        4 => "street",
        5 => "city",
        6 => "postcode",
        7 => "country"
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the filtered clients list
     *
     * @param Client $clients
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Client $clients, Request $request)
    {

        // Filter by alphabetical
        if (!empty($request->alphabetical)) {

            $filterByStartLetter = $request->alphabetical;

            /**
             * Get the alphabetical filtered clients list
             */
            $collectionFiltered = $clients
                ->orderBy('name')
                ->get();

            $alphabetical = $collectionFiltered
                ->groupBy(function ($item, $key) {
                    return substr($item->name, 0, 1);
                });

            /**
             * Get the alphabetical letters list
             */
            $collection = $clients
                ->orderBy('name')
                ->where('name', 'like', $filterByStartLetter . '%')
                ->get();

            $clientsGrouped = $collection
                ->groupBy(function ($item, $key) {
                    return substr($item->name, 0, 1);
                });

        } else {

            $filterByStartLetter = "";

            /**
             * Get the unfiltered clients list
             */
            $collection = $clients
                ->orderBy('name')
                ->get();

            $clientsGrouped = $alphabetical = $collection
                ->groupBy(function ($item, $key) {
                    return substr($item->name, 0, 1);
                });

        }

        $columnsHeader = $this->headerFormat;

        return view('clients.show', compact('clientsGrouped', 'columnsHeader', 'alphabetical', 'filterByStartLetter'));
    }

    /**
     * Show the form for uploading the clients.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import()
    {
        return view('clients.import');
    }

    /**
     * Store the submitted clients to the database.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {

        // Check file is uploaded
        if (!$request->hasFile('clients_list')) {
            session()->flash('message_important', 'Missing a file! Please select a correct CSV file.');
            return view('clients.import');
        }

        // Basic validation for a file.
        $this->validate($request, [
            'clients_list' => 'required|mimes:txt|file|max:2048',
        ]);

        $file = $request->file('clients_list');

        // Check the extension
        if ($file->getClientOriginalExtension() !== 'csv') {
            session()->flash('message_important', 'Wrong file extension! Please select a correct CSV file.');
            return view('clients.import');
        }

        $filePath = $file->getRealPath();

        $clientData = array_map('str_getcsv', file($filePath));

        // First row is the identifier
        $clientFileHeadline = $clientData[0];

        $difference = array_diff($this->headerFormat, $clientFileHeadline);

        // If has a difference, that means, we found an error in the columns
        if (!empty($difference)) {
            session()->flash('message_important', 'Wrong file header, the columns are mismatch! Please select a correct CSV file. The correct format is: ' . implode(', ', $this->headerFormat));
            return view('clients.import');
        }

        // Clear the table
        Client::truncate();

        // Remove the CSV header
        unset($clientData[0]);

        // Iterate over the clients
        foreach ($clientData as $row) {

            $client = new Client();

            // Prepare the client data
            foreach ($this->headerFormat as $index => $field) {

                $client->$field = $row[$index];
            }

            $client->save();
        }

        session()->flash('message', 'Client database successfully imported.');

        return redirect('clients');
    }
}
