<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Whatsapp;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Livewire\Component;

class WhatsappDashboard extends Component
{

    public $newPassword = '';
    public $confirmPassword = '';
    public $oldPassword = '';
    public $listCollections = [];
    public $usedInstance;
    public $totalQuota = 0;

    public function mount()
    {
        $response = $this->getListCollection();
        if($response === false){
            $response = $this->requestLogin();
            $whatsappInstance = Whatsapp::first();
            if(!$whatsappInstance){
                $whatsappInstance = new Whatsapp();
            }
            $whatsappInstance->access_token = $response;
            $whatsappInstance->device_name = '';
            $whatsappInstance->save();
            return;
        }
        $this->listCollections = $response;
    }

    public function updatePassword()
    {
        if($this->newPassword != $this->confirmPassword || $this->newPassword == ''){
            return [
                'status' => false,
                'message' => 'Password tidak sama atau kosong'
            ];
        }
        try{
            $client = new Client();
            $accessToken = Whatsapp::first()->access_token;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/update-password',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'password' => $this->oldPassword,
                    'newPassword' => $this->newPassword,
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                $whatsappInstance = Whatsapp::first();
                $whatsappInstance->password = $this->newPassword;
                $whatsappInstance->save();
                // change User instance with admin@gmail.com with that password too, and implement the hash
                $userInstance = User::first();
                $userInstance->password = bcrypt($this->newPassword);
                $userInstance->save();
                return true;
            }
            return false;
        }
        catch(ClientException $e){
            return false;
        }
        catch(ConnectException $e){
            return false;

        }
    }

    public function useInstance($instanceName){
        $isInstanceOnDb = Whatsapp::where('device_name',$instanceName)->first();
        if(!$isInstanceOnDb){
            $whatsappInstance = Whatsapp::first();
            $whatsappInstance->device_name = $instanceName;
            $whatsappInstance->save();
        }
        $this->listCollections = array_map(function($item) use ($instanceName){
            if($item->token == $instanceName){
                $item->is_active = true;
            }
            return $item;
        },$this->listCollections);
        $this->usedInstance = $instanceName;
        return [
            'status' => true,
            'message' => 'Berhasil menggunakan instance'
        ];
    }

    public function deleteInstance($instanceName)
    {
        try{
            $client = new Client();
            $accessToken = Whatsapp::first()->access_token;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/delete-instance',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'token' => $instanceName,
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                $isInstanceOnDb = Whatsapp::where('device_name',$instanceName)->first();
                if($isInstanceOnDb){
                    $isInstanceOnDb->device_name = '';
                    $isInstanceOnDb->save();
                }
                $this->listCollections = array_filter($this->listCollections,function($item) use ($instanceName){
                    return $item->token != $instanceName;
                });
                return [
                    'status' => true,
                    'message' => 'Berhasil menghapus instance'
                ];
            }

        }catch(ClientException $e){
            return $e->getResponse()->getBody()->getContents();
        }
        catch(ConnectException $e){
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function createInstance($deviceName)
    {
      try{
            $client = new Client();
            $accessToken = Whatsapp::first()->access_token;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/create-instance',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'token' => $deviceName,
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                return [
                    'status' => true,
                    'message' => 'Berhasil membuat instance, menunggu qrcode'
                ];
            }

        }catch(ClientException $e){
            return $e->getResponse()->getBody()->getContents();
        }catch(ConnectException $e){
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getListCollection()
    {
        try{
            $token = Whatsapp::first();
            if(!$token){
                return false;
            }
            $this->usedInstance = $token->device_name;
            $client = new Client();
            $response = $client->request('GET',env('WHATSAPP_URL').'/api/get-all-instance',
            [
                'headers' => [
                    'x-access-token' => $token->access_token,
                ]
            ]);
            // if response status 401 return false
            if($response->getStatusCode() != 200){
                return false;
            }
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                $this->totalQuota = $response->totalQuota;
                $response = $response->data;
                foreach($response as $item){
                    if($item->token == $this->usedInstance){
                        $item->is_active = true;
                    }else{
                        $item->is_active = false;
                    }
                }
                $this->listCollections = $response;
                return $response;
            }
            return false;            
        }catch(ClientException $e){
            // get json response from server
            $this->listCollections = [];
            return false;
        }catch(ConnectException $e){
            $this->listCollections = [];
            return false;
        }
    }

    protected function requestLogin()
    {
        try{
            $client = new Client();
            $whatsappInstance = Whatsapp::first();
            $response = $client->request('POST', env('WHATSAPP_URL').'/api/signin', [
                // sent form-data
                'form_params' => [
                    'email' => $whatsappInstance->email,
                    'password'=> $whatsappInstance->password,
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                return $response->token;
            }
            return false;
        }
        catch(ClientException $e){
            return false;
        }
        catch(ConnectException $e){
            return false;
        }
    }

    public function render()
    {
        return view('livewire.whatsapp-dashboard');
    }
}
