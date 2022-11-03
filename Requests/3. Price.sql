select model_name, color, upholstery, engine_power, doors_count, transmission, price
from models 
inner join price_list on models.id = price_list.id
where price_list.price > 500000 and price_list.price < 800000;	