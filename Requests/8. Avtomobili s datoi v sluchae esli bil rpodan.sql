use mydb;
select models.model_name, clients.date_of_purchase
from models join clients on clients.id_model = models.id
where clients.id_model is not null;