use mydb;
select model_name, price_list.price, clients.date_of_purchase
from models join clients on models.id = clients.id_model
join price_list on clients.id_model = price_list.id
where month(clients.date_of_purchase) = 1;