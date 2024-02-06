<?php
$cp_user = $this->get_credits();
if($engine_type=='chat'){
    $prompt_tokens = ($tokens['prompt_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
    $completion_tokens = ($tokens['completion_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
    $cp_calc = $prompt_tokens + $completion_tokens;
}else{
    $cp_calc = ($tokens['total_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
}


$cp_update = $cp_user - $cp_calc;

$update_data = array();
$update_data['n_credits'] = $cp_update;



$query ='UPDATE `users` SET n_credits = '.$cp_update.' where id='.$this->n_bot_data['user_id'];
$query .= ' LIMIT 1';

$sth = $this->n_pdo->prepare($query);

$sth->execute();

$return_calc_tokens = round($cp_update, 2);