use mydb;
create view Otchet_o_realizacii_avtomobilei as select providers.name_firm, models.model_name, 
price_list.price, price_list.transport_costs, price_list.presale_preparation, price_list.price+price_list.transport_costs+price_list.presale_preparation as Total_cost
from price_list join models on price_list.id = models.id 
join providers_has_models on providers_has_models.models_id_model = models.id 
join providers on providers.id = providers_has_models.providers_id_firm