select clients.full_name, models.model_name, price_list.price
from clients join models on clients.id_model = models.id
join price_list on models.id = price_list.id
where clients.full_name like 'Tinkoff_V%_I%';