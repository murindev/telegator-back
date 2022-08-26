# run this protection
exit 0

# load CSV

php artisan parse:csv /hdd/list.csv --first=10

# Make model
#   -m      Create a new migration file for the model

php artisan make:model -m TelegramUser


# Make policy
#   --model      generate a class with example policy methods

php artisan make:policy CampaignPolicy --model=Campaign

# Make command

php artisan make:command CommandName

# Make job

php artisan make:job ParseTgStatChannelInfo





/\$table->(\w+)\('(\w+)'.*/ - regexp to migration


про транзакции, пока придумал только следующий словарик

deposit - для транзакций типа поступления средств на баланс пользователя
withdraw - для транзакций вывода средств с баланса
transfer - для тразнакций перевода внутри нашей системы (как внутрених так и между счетами пользователей)
source - источник перевода (пользователь и тип баланса [balance|hold])
destination - назначение перевода (пользователь и тип баланса [balance|hold])

пример оплаты задания (из "холда" 10 пользователя, переводится пользователю 15)
{
    transaction_id: 123,
    type: transfer,
    source_id: 10,
    source_type: hold,
    destination: 15,
    destination_type: balance,
    value: 155.70,
    created_at: '2021-04-05T17:20:37.789464Z'
}
