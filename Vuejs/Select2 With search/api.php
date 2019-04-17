<?php
class Select2 {
    public function getAirlines()
    {
        $response = [];
        $airlines = [];
        $status = 200;
        try {
            $airlinesData = Airline::limit(100)->get();
            //prepare data for select2
            foreach ($airlinesData as $data) {
                $airlines[] = [
                    'label' => $data->name,
                    'id' => $data->id,
                    'value' => $data->name,
                    'country' => $data->country,
                ];
            }
            $response['airlines'] = $airlines;
            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }
    public function searchAirlines(Request $request)
    {
        $response = [];
        $airlines = [];
        $status = 200;
        try {
            $airlinesData = Airline::where('name', $request->q)
                ->orWhere('name', 'like', '%' . $request->q . '%')
                ->get();
            //prepare data for select2
            foreach ($airlinesData as $data) {
                $airlines[] = [
                    'label' => $data->name,
                    'id' => $data->id,
                    'value' => $data->name,
                    'country' => $data->country,
                ];
            }
            $response['airlines'] = $airlines;
            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }
}
?>