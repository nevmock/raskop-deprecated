<?php

namespace App\Filament\Resources\ReservasiResource\Pages;

use App\Filament\Resources\ReservasiResource;
use App\Models\Reservasi;
use App\Models\Whatsapp;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class ViewReservasi extends ViewRecord
{
    protected static string $resource = ReservasiResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
            ->label('Konfirmasi')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-check-circle')
            ->modalDescription('Apakah anda yakin ingin menerima reservasi ini?')
            ->modalSubmitActionLabel('Terima')
            ->action(function (Reservasi $reservasi) {
                $reservasi->status = 'approved';
                $reservasi->save();
                $this->sendApprovedMessage($reservasi->customer->phone,$reservasi->kode_reservasi);
                Notification::make()
                ->title($reservasi->kode_reservasi.' Berhasil Diterima')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
                redirect()->to('/admin/reservasi');
            })
            ->successRedirectUrl('/admin/reservasi')
            ,
            Action::make('reject')
            ->label('Tolak')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-x-circle')
            ->modalDescription('Apakah anda yakin ingin menolak reservasi ini?')
            ->modalSubmitActionLabel('Tolak')
            ->action(function (Reservasi $reservasi) {
                $reservasi->status = 'rejected';
                $reservasi->save();
                $this->sendRejectedMessage($reservasi->customer->phone,$reservasi->kode_reservasi);
                Notification::make()
                ->title($reservasi->kode_reservasi.' Ditolak')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
                redirect()->to('/admin/reservasi');
            })
        ];
    }

    protected function sendApprovedMessage($number,$kodeReservasi)
    {   
        try{
            $client = new Client();
            $user = Whatsapp::first();
            $accessToken = $user->access_token;
            $deviceName = $user->device_name;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/send-message',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'number' => $number,
                    'message' => "Reservasi dengan kode : *".$kodeReservasi."* di terima.\n\n silahkan untuk datang tepat waktu",
                    'token'=> $deviceName
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            return $response;
        }catch(ClientException $e){
            $res = $e->getResponse()->getStatusCode();
            if($res == 401){
                $token = $this->requestLogin();
                if($token){
                    $whatsappInstance = Whatsapp::first();
                    $whatsappInstance->update([
                        'access_token' => $token
                    ]);
                    $this->sendApprovedMessage($number,$kodeReservasi);
                }
            }
        }
        catch(ConnectException $e){
            return false;
        }
    }
    protected function sendRejectedMessage($number,$kodeReservasi)
    {   
        try{
            $client = new Client();
            $user = Whatsapp::first();
            $accessToken = $user->access_token;
            $deviceName = $user->device_name;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/send-message',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'number' => $number,
                    'message' => "Reservasi dengan kode : *".$kodeReservasi."* Ditolak dengan alasan anda bohong",
                    'token'=> $deviceName
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            return $response;
        }catch(ClientException $e){
            $res = $e->getResponse()->getStatusCode();
            if($res == 401){
                $token = $this->requestLogin();
                if($token){
                    $whatsappInstance = Whatsapp::first();
                    $whatsappInstance->update([
                        'access_token' => $token
                    ]);
                    $this->sendRejectedMessage($number,$kodeReservasi);
                }
            }
        }
        catch(ConnectException $e){
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

    
}
