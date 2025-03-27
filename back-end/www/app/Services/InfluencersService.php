<?php
 
namespace App\Services;

use App\Repositories\InfluencersRepository;
use Illuminate\Support\Facades\Validator;

 
class InfluencersService 
{
    public function __construct(
        private InfluencersRepository $influencersRepository
    ){}
 
    /**
     * Summary of saveInfluencers
     * @param array $data
     * @return array{id: int|mixed|\Illuminate\Http\JsonResponse}
     */
    public function saveInfluencers(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:30',
            'instagram' => 'required|string|max:30|unique:influencers',
            'qtd_followers' => 'required|numeric|min:0',
            'category' => 'required|in:Tecnologia,Beleza,Saúde'
        ]);
        
        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        $id = $this->influencersRepository->insertInfluencer($data);

        return ['id' => $id];
    }
    
    /**
     * Summary of listInfluencers
     * @return array
     */
    public function listInfluencers(): array
    {
        return $this->influencersRepository->listInfluencers()->toArray();
    }
}