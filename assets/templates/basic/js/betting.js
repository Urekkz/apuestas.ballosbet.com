(function ($) {
    "use strict";

    console.log('🎰 Betting.js cargado correctamente');

    // Variables globales
    let selectedOutcome = null;
    let selectedOdds = null;
    let selectedAmount = null;
    let selectedOutcomeName = '';
    // Exponer a window para consumo por otras utilidades (p.ej. updateReturnAmount)
    window.currentOdds = null;
    window.currentFavoritismo = window.currentFavoritismo || null;

    // Obtener balance del usuario desde el HTML
    function getUserBalance() {
        // Primero intentar obtenerlo desde el modal de apuesta
        const balanceElement = $('#userBalance');
        if (balanceElement.length) {
            const balanceText = balanceElement.text().trim();
            const match = balanceText.match(/[\d,.]+/);
            if (match) {
                return parseFloat(match[0].replace(/,/g, ''));
            }
        }
        
        // Si no está disponible, intentar desde el usuario autenticado
        if (typeof window.userBalance !== 'undefined') {
            return parseFloat(window.userBalance);
        }
        
        console.warn('⚠️ No se pudo obtener el balance del usuario');
        return 0;
    }

    // Actualizar el balance en tiempo real
    function updateBalanceDisplay(newBalance) {
        if (typeof showAmount === 'function') {
            $('#userBalance').html(showAmount(newBalance) + ' <a href="/user/deposit" class="btn btn--sm btn--success"> <i class="la la-plus"></i> Agregar Balance</a>');
        }
    }

    // Actualizar preview del bet slip inmediatamente
    function updateBetSlipPreview() {
        if (!selectedOutcome) {
            return;
        }

        // Crear o actualizar el preview en el bet slip
        let $betSlipContainer = $('.bet-slip-container');
        
        if ($betSlipContainer.length === 0) {
            console.warn('⚠️ No se encontró el contenedor del bet slip');
            return;
        }

        // Buscar si ya existe un item de preview
        let $previewItem = $betSlipContainer.find('.bet-slip-preview-item');
        
        const previewHTML = `
            <div class="bet-slip-preview-item alert alert-info mb-2 fade-in" style="animation: fadeIn 0.3s;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${selectedOutcomeName}</strong>
                        <div class="small text-muted">Cuota: ${selectedOdds}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger clear-selection">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
        `;

        if ($previewItem.length > 0) {
            $previewItem.replaceWith(previewHTML);
        } else {
            // Insertar al principio del bet slip body
            let $betSlipBody = $betSlipContainer.find('.betslip__body, .bet-slip-body');
            if ($betSlipBody.length > 0) {
                $betSlipBody.prepend(previewHTML);
            }
        }

        console.log('✅ Preview del bet slip actualizado');
    }

    // Limpiar selección desde el preview
    $(document).on('click', '.clear-selection', function(e) {
        e.preventDefault();
        $('.oddBtn').removeClass('selected-outcome');
        $('.bet-slip-preview-item').remove();
        selectedOutcome = null;
        selectedOdds = null;
        selectedOutcomeName = '';
        window.currentOdds = null;
        console.log('🧹 Selección limpiada');
    });

    // Validar si el usuario tiene suficiente saldo
    function validateBalance(amount) {
        const currentBalance = getUserBalance();
        console.log('💰 Balance actual:', currentBalance, '| Monto a apostar:', amount);
        
        if (amount > currentBalance) {
            notify('error', `No tienes suficiente saldo. Balance actual: $${currentBalance.toFixed(2)}`);
            return false;
        }
        return true;
    }

    // Manejar click en botones de odds (seleccionar gallo)
    $(document).on('click', '.oddBtn:not(.locked)', function (e) {
        e.preventDefault();
        
        const $btn = $(this);
        const outcomeId = $btn.data('outcome_id');
        const oddsValue = parseFloat($btn.data('odds'));
        const outcomeName = $btn.data('outcome_name');

        console.log('🎯 Click en botón de odds:', {outcomeId, oddsValue, outcomeName});

        // Si ya está seleccionado, deseleccionar
        if ($btn.hasClass('selected-outcome')) {
            $btn.removeClass('selected-outcome');
            selectedOutcome = null;
            selectedOdds = null;
            selectedOutcomeName = '';
            window.currentOdds = null;
            console.log('❌ Deseleccionado');
            return;
        }

        // Deseleccionar otros botones del mismo juego
        $btn.closest('.sports-card').find('.oddBtn').removeClass('selected-outcome');
        
        // Seleccionar este botón con animación visual
        $btn.addClass('selected-outcome');
        
        // Agregar feedback visual inmediato
        $btn.css('transform', 'scale(0.95)');
        setTimeout(() => {
            $btn.css('transform', 'scale(1)');
        }, 100);
        
        selectedOutcome = outcomeId;
        selectedOdds = oddsValue;
        selectedOutcomeName = outcomeName;
        // mantenerlo accesible globalmente (para updateReturnAmount u otras utilidades)
        window.currentOdds = selectedOdds;

        console.log('✅ Outcome seleccionado:', {selectedOutcome, selectedOdds, selectedOutcomeName});

        // Agregar inmediatamente al bet slip visual para feedback instantáneo
        updateBetSlipPreview();

        // Si ya hay un monto seleccionado, permitir apostar
        if (selectedAmount && selectedAmount > 0) {
            console.log('💵 Ya hay monto seleccionado, mostrando confirmación');
            showBetConfirmation();
        } else {
            notify('info', 'Ahora selecciona un monto para apostar');
        }
    });

    // Manejar click en botones de monto
    $(document).on('click', '.bet-amount-btn', function (e) {
        e.preventDefault();
        
        const amount = parseFloat($(this).data('amount'));
        selectedAmount = amount;

        console.log('💵 Monto seleccionado:', selectedAmount);

        // Resaltar botón seleccionado
        $('.bet-amount-btn').removeClass('btn-success').addClass('btn-outline-success');
        $(this).removeClass('btn-outline-success').addClass('btn-success');

        // Si ya hay un outcome seleccionado, mostrar confirmación
        if (selectedOutcome) {
            console.log('✅ Outcome ya seleccionado, mostrando confirmación');
            showBetConfirmation();
        } else {
            notify('info', 'Por favor selecciona un gallo primero (Gallo 1 o Gallo 2)');
        }
    });

    // Manejar apuesta personalizada
    $(document).on('click', '.custom-bet', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('🎨 Click en apuesta personalizada');
        
        // Encontrar el modal más cercano en el contenedor del juego
        const gameContainer = $(this).closest('.sports-card, .sports-card-inner').parent();
        const modal = gameContainer.find('.custom-modal').first();
        
        if (modal.length) {
            modal.css('display', 'flex').fadeIn(200);
            modal.find('.custom-bet-input').val('').focus();
            console.log('✅ Modal abierto correctamente');
        } else {
            console.error('❌ No se encontró el modal personalizado');
            notify('error', 'Error al abrir el modal de apuesta personalizada');
        }
    });

    $(document).on('click', '.cancel-custom-bet', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('❌ Cancelar apuesta personalizada');
        
        const modal = $(this).closest('.custom-modal');
        modal.fadeOut(200, function() {
            $(this).css('display', 'none');
        });
        modal.find('#customBetInput').val('');
    });

    $(document).on('click', '.save-custom-bet', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        const modal = $(this).closest('.custom-modal');
        const customInput = modal.find('.custom-bet-input');
        const customAmount = parseFloat(customInput.val());

        console.log('💰 Intentando guardar monto personalizado:', customAmount);

        if (!customAmount || customAmount <= 0 || isNaN(customAmount)) {
            notify('error', 'Por favor ingresa un monto válido mayor a 0');
            customInput.focus();
            return;
        }

        // Validar balance antes de continuar
        if (!validateBalance(customAmount)) {
            customInput.val('');
            customInput.focus();
            return;
        }

        selectedAmount = customAmount;
        console.log('✅ Monto personalizado guardado:', selectedAmount);
        
        modal.fadeOut(200, function() {
            $(this).css('display', 'none');
        });
        customInput.val('');

        // Deseleccionar botones de monto predefinido
        $('.bet-amount-btn').removeClass('btn-success').addClass('btn-outline-success');

        // Si ya hay un outcome seleccionado, mostrar confirmación
        if (selectedOutcome) {
            console.log('✅ Outcome ya seleccionado, mostrando confirmación');
            showBetConfirmation();
        } else {
            notify('info', 'Ahora selecciona un gallo (izquierda o derecha)');
        }
    });

    // Cerrar modal al hacer clic fuera
    $(document).on('click', '.custom-modal', function (e) {
        if ($(e.target).hasClass('custom-modal')) {
            console.log('🚪 Cerrando modal por clic fuera');
            $(this).fadeOut(200, function() {
                $(this).css('display', 'none');
            });
            $(this).find('#customBetInput').val('');
        }
    });

    // Permitir enviar con Enter en el input personalizado
    $(document).on('keypress', '.custom-bet-input', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $(this).closest('.custom-modal').find('.save-custom-bet').click();
        }
    });

    // Mostrar modal de confirmación de apuesta
    function showBetConfirmation() {
        console.log('📋 Mostrando modal de confirmación');
        
        if (!selectedOutcome || !selectedAmount || selectedAmount <= 0) {
            console.error('❌ Faltan datos:', {selectedOutcome, selectedAmount});
            return;
        }

        // Validar saldo antes de mostrar el modal
        if (!validateBalance(selectedAmount)) {
            return;
        }

        // Exponer las variables actuales globalmente para que otras funciones las usen
        window.currentOdds = selectedOdds;
        window.currentStake = selectedAmount;
        // Si existe un favoritismo asociado, podría establecerse aquí también
        // window.currentFavoritismo = ...;

        // Calcular retorno sobre el monto COMPLETO
        // La comisión del 5% solo se cobrará al ganador cuando gane
        const returnAmount = selectedAmount * selectedOdds;
        
        console.log('💰 Detalles de apuesta:', {
            stake: selectedAmount,
            odds: selectedOdds,
            return: returnAmount,
            note: 'Comisión del 5% se cobrará solo al ganador'
        });
        
        // Verificar que el modal existe
        const modalElement = document.getElementById('betModal');
        if (!modalElement) {
            console.error('❌ Modal #betModal no encontrado en el DOM');
            notify('error', 'Error: Modal de apuesta no disponible. Por favor recarga la página.');
            return;
        }
        
        console.log('✅ Modal encontrado, actualizando valores...');
        
        // Mostrar el monto apostado y ganancia potencial
        $('#betStakeAmount').text(showAmount(selectedAmount));
        $('#betReturnAmount').text(showAmount(returnAmount));
        
        // Actualizar los campos del formulario
        $('[name="stake_amount"]').val(selectedAmount);
        $('[name="type"]').val(1); // Single bet

        console.log('🚀 Intentando mostrar modal...');
        
        // Verificar que Bootstrap está disponible
        if (typeof bootstrap === 'undefined') {
            console.error('❌ Bootstrap no está cargado');
            notify('error', 'Error: Bootstrap no está disponible. Por favor recarga la página.');
            return;
        }

        try {
            // Mostrar el modal
            const betModal = new bootstrap.Modal(modalElement);
            betModal.show();
            console.log('✅ Modal mostrado exitosamente');
        } catch (error) {
            console.error('❌ Error al mostrar modal:', error);
            notify('error', 'Error al mostrar el modal de confirmación');
        }
    }

    // Manejar el envío de la apuesta
    $('#betForm').on('submit', function (e) {
        e.preventDefault();

        console.log('📤 Enviando apuesta...');

        // Validar nuevamente el saldo antes de enviar
        if (!validateBalance(selectedAmount)) {
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('betModal'));
            if (modalInstance) {
                modalInstance.hide();
            }
            return;
        }

        const $submitBtn = $(this).find('[type="submit"]');
        
        // Limpiar el bet slip primero para evitar duplicados
        console.log('🧹 Limpiando bet slip anterior...');
        $.ajax({
            url: '/bet/remove-all',
            method: 'POST',
            data: {
                _token: $('[name="_token"]').val()
            },
            complete: function() {
                // Ahora agregar el outcome seleccionado a la sesión
                console.log('➕ Agregando outcome a bet slip:', selectedOutcome);
                
                $.ajax({
                    url: '/bet/add-to-bet-slip',
                    method: 'GET',
                    data: {
                        id: selectedOutcome,
                        type: 1,
                        amount: selectedAmount
                    },
                    success: function(response) {
                console.log('📥 Respuesta de add-to-bet-slip:', response);
                
                if (response.error) {
                    console.error('❌ Error al agregar:', response.error);
                    
                    // Mostrar información de debug si existe
                    if (response.debug) {
                        console.group('🔍 DEBUG INFO');
                        console.table(response.debug);
                        console.log('Reason:', response.reason);
                        console.groupEnd();
                        
                        // Mostrar en alert para que sea más visible
                        alert('ERROR DEBUG:\n\n' + JSON.stringify(response.debug, null, 2));
                    }
                    
                    const errorMsg = Array.isArray(response.error) ? response.error.join(', ') : response.error;
                    notify('error', errorMsg);
                    return;
                }

                console.log('✅ Outcome agregado, enviando apuesta...');

                // Ahora enviar la apuesta
                $submitBtn.prop('disabled', true).text('Procesando...');
                
                const formData = new FormData(document.getElementById('betForm'));
                
                // Todas las apuestas NO deben abrirse automáticamente en todos los casos.
                // Solo marcar como abierta (is_open=1) cuando el tipo de apuesta sea SINGLE (type == 1),
                // para respetar la UI/UX mostrada en el diseño y evitar que multi-bets se hagan públicas.
                try {
                    const currentType = formData.get('type');
                    if (currentType === '1' || currentType === 1) {
                        formData.append('is_open', '1');
                        console.log('✅ Apuesta automáticamente abierta (pública) para tipo SINGLE');
                    } else {
                        console.log('ℹ️ No se marca is_open para apuestas de tipo diferente a SINGLE:', currentType);
                    }
                } catch (e) {
                    // En caso de error, no añadimos is_open para prevenir cambios inesperados en visibilidad
                    console.error('❌ Error al determinar tipo de apuesta para is_open:', e);
                }
                
                $.ajax({
                    url: $('#betForm').attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('📥 Respuesta del servidor:', response);
                        
                        if (response.status === 'success') {
                            notify('success', '¡Apuesta realizada! Tu apuesta ahora es pública y otros pueden taparla');
                            
                            // Actualizar el balance del usuario
                            if (typeof response.balance !== 'undefined' && typeof showAmount === 'function') {
                                updateBalanceDisplay(response.balance);
                                window.userBalance = response.balance;
                            }
                            
                            // Actualizar la sección de apuestas abiertas SIN recargar la página
                            if (response.openBetsHtml) {
                                const $newOpenBets = $(response.openBetsHtml);
                                const $currentOpenBets = $('.open-bets-section, .no-open-bets').first().parent();
                                
                                if ($currentOpenBets.length) {
                                    // Reemplazar toda la sección con animación suave
                                    $currentOpenBets.fadeOut(200, function() {
                                        $(this).html($newOpenBets).fadeIn(300);
                                    });
                                    console.log('✅ Apuestas abiertas actualizadas automáticamente');
                                } else {
                                    // Si no existe, buscar dónde insertarla
                                    const $container = $('.sports-card, .game-container').first();
                                    if ($container.length) {
                                        $container.after($newOpenBets);
                                        console.log('✅ Sección de apuestas abiertas agregada');
                                    }
                                }
                            }
                            
                            // Actualizar "Mis Apuestas" si viene en la respuesta
                            if (response.html) {
                                try {
                                    $('.mybet-container').html(response.html);
                                    console.log('✅ Mis apuestas actualizadas');
                                } catch (e) {
                                    console.warn('⚠️ No se pudo actualizar "Mis Apuestas":', e);
                                }
                            }
                            
                            // Cerrar el modal de confirmación
                            const modalElement = document.getElementById('betModal');
                            if (modalElement) {
                                const betModal = bootstrap.Modal.getInstance(modalElement);
                                if (betModal) {
                                    betModal.hide();
                                }
                            }
                            
                            // Limpiar la selección actual
                            $('.oddBtn').removeClass('selected-outcome');
                            $('.bet-slip-preview-item').remove();
                            $('.bet-amount-btn').removeClass('btn-success').addClass('btn-outline-success');
                            selectedOutcome = null;
                            selectedOdds = null;
                            selectedAmount = null;
                            selectedOutcomeName = '';
                            window.currentOdds = null;
                            
                            console.log('✅ Apuesta procesada exitosamente SIN recargar la página');
                        } else {
                            notify('error', response.message || 'Error al realizar la apuesta');
                        }
                    },
                    error: function (xhr) {
                        console.error('❌ Error en servidor:', xhr);
                        const errorMsg = xhr.responseJSON?.message || 'Error al procesar la apuesta';
                        notify('error', errorMsg);
                    },
                    complete: function () {
                        $submitBtn.prop('disabled', false).text('Confirmar Apuesta');
                    }
                });
            },
            error: function(xhr) {
                console.error('❌ Error al agregar a bet slip:', xhr);
                console.error('❌ Status:', xhr.status);
                console.error('❌ Response:', xhr.responseText);
                
                let errorMsg = 'Error al agregar apuesta';
                
                if (xhr.responseJSON) {
                    console.log('📦 Respuesta JSON completa:', xhr.responseJSON);
                    
                    // Mostrar debug si existe
                    if (xhr.responseJSON.debug) {
                        console.group('🔍 DEBUG INFO DETALLADO');
                        console.table(xhr.responseJSON.debug);
                        console.log('Reason:', xhr.responseJSON.reason);
                        console.groupEnd();
                        
                        // Mostrar en alert para que sea MUY visible
                        alert('DEBUG INFO:\n\n' + JSON.stringify(xhr.responseJSON.debug, null, 2) + '\n\nReason: ' + xhr.responseJSON.reason);
                    }
                    
                    if (xhr.responseJSON.error) {
                        errorMsg = Array.isArray(xhr.responseJSON.error) 
                            ? xhr.responseJSON.error.join(', ') 
                            : xhr.responseJSON.error;
                    } else if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                }
                
                notify('error', errorMsg);
                    },
                    error: function(xhr) {
                        console.error('❌ Error al agregar a bet slip:', xhr);
                        console.error('❌ Status:', xhr.status);
                        console.error('❌ Response:', xhr.responseText);
                        
                        let errorMsg = 'Error al agregar apuesta';
                        
                        if (xhr.responseJSON) {
                            console.log('📦 Respuesta JSON completa:', xhr.responseJSON);
                            
                            // Mostrar debug si existe
                            if (xhr.responseJSON.debug) {
                                console.group('🔍 DEBUG INFO DETALLADO');
                                console.table(xhr.responseJSON.debug);
                                console.log('Reason:', xhr.responseJSON.reason);
                                console.groupEnd();
                                
                                // Mostrar en alert para que sea MUY visible
                                alert('DEBUG INFO:\n\n' + JSON.stringify(xhr.responseJSON.debug, null, 2) + '\n\nReason: ' + xhr.responseJSON.reason);
                            }
                            
                            if (xhr.responseJSON.error) {
                                errorMsg = Array.isArray(xhr.responseJSON.error) 
                                    ? xhr.responseJSON.error.join(', ') 
                                    : xhr.responseJSON.error;
                            } else if (xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                        }
                        
                        notify('error', errorMsg);
                    }
                });
            }
        });
    });

    // Alternar entre tabs de Bet Slip y My Bets
    $('input[name="bet-type"]').on('change', function() {
        if ($(this).attr('id') === 'betslips') {
            $('.bet-slip-container').show();
            $('.mybet-container').hide();
        } else {
            $('.bet-slip-container').hide();
            $('.mybet-container').show();
        }
    });

    // ========================================
    // FUNCIONALIDAD DE TAPAR APUESTAS
    // ========================================

    // Manejar click en botón "Tapar Apuesta"
    $(document).on('click', '.btn-match-bet', function(e) {
        e.preventDefault();
        
        const $btn = $(this);
        const betId = $btn.data('bet-id');
        const amount = parseFloat($btn.data('amount'));
        const oppositeOutcomeId = $btn.data('opposite-outcome-id');
        const oppositeOutcomeName = $btn.data('opposite-outcome-name');
        const odds = parseFloat($btn.data('odds'));

        console.log('🤝 Intentando tapar apuesta:', {
            betId,
            amount,
            oppositeOutcomeId,
            oppositeOutcomeName,
            odds
        });

        // Validar saldo
        if (!validateBalance(amount)) {
            return;
        }

        // Calcular retorno sobre el monto COMPLETO
        // La comisión del 5% solo se cobrará al ganador cuando gane
        const returnAmount = amount * odds;

        // Mostrar confirmación
        const confirmMsg = `¿Deseas tapar esta apuesta?\n\n` +
                          `Apostarás: ${showAmount(amount)}\n` +
                          `A favor de: ${oppositeOutcomeName}\n` +
                          `Cuota: ${odds}\n` +
                          `Ganancia potencial: ${showAmount(returnAmount)}\n` +
                          `(Si ganas, se cobrará 5% de comisión sobre tu ganancia)\n\n` +
                          `Se deducirá de tu balance inmediatamente.`;

        if (!confirm(confirmMsg)) {
            console.log('❌ Usuario canceló el tapado de apuesta');
            return;
        }

        // Deshabilitar botón mientras procesa
        $btn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Procesando...');

        // Enviar petición AJAX
        $.ajax({
            url: '/user/bet/match-bet',
            method: 'POST',
            data: {
                original_bet_id: betId,
                outcome_id: oppositeOutcomeId,
                _token: $('[name="_token"]').val()
            },
            success: function(response) {
                console.log('✅ Apuesta tapada exitosamente:', response);
                
                notify('success', response.message || '¡Apuesta tapada exitosamente!');

                // Actualizar el balance del usuario
                if (typeof response.balance !== 'undefined' && typeof showAmount === 'function') {
                    updateBalanceDisplay(response.balance);
                    window.userBalance = response.balance;
                }

                // Actualizar la sección de apuestas abiertas SIN recargar
                if (response.openBetsHtml) {
                    const $newOpenBets = $(response.openBetsHtml);
                    const $currentOpenBets = $('.open-bets-section');
                    
                    if ($currentOpenBets.length) {
                        // Animar la actualización
                        $currentOpenBets.fadeOut(200, function() {
                            $(this).replaceWith($newOpenBets);
                            $newOpenBets.hide().fadeIn(300);
                        });
                        console.log('✅ Apuestas abiertas actualizadas tras tapar');
                    }
                }

                // Actualizar "Mis Apuestas"
                if (response.html) {
                    try {
                        $('.mybet-container').html(response.html);
                        console.log('✅ Mis apuestas actualizadas tras tapar');
                    } catch (e) {
                        console.warn('⚠️ No se pudo actualizar "Mis Apuestas":', e);
                    }
                }

                console.log('✅ Apuesta tapada procesada SIN recargar la página');
            },
            error: function(xhr) {
                console.error('❌ Error al tapar apuesta:', xhr);
                
                const errorMsg = xhr.responseJSON?.message || 'Error al tapar la apuesta';
                notify('error', errorMsg);
                
                // Re-habilitar botón
                $btn.prop('disabled', false).html('<i class="las la-hand-rock"></i> Tapar Apuesta');
            }
        });
    });

    // Función para recargar las apuestas abiertas automáticamente
    window.refreshOpenBets = function() {
        console.log('🔄 Actualizando apuestas abiertas...');
        
        // Recargar solo la sección de apuestas abiertas
        $.ajax({
            url: window.location.href,
            method: 'GET',
            dataType: 'html',
            cache: false,
            success: function(html) {
                try {
                    const $html = $(html);
                    
                    // Actualizar sección de apuestas abiertas
                    const $newOpenBets = $html.find('.open-bets-section');
                    const $currentOpenBets = $('.open-bets-section');
                    const $noOpenBets = $('.no-open-bets');
                    
                    if ($newOpenBets.length && $currentOpenBets.length) {
                        // Comparar si hay cambios antes de actualizar (para evitar parpadeos innecesarios)
                        const currentHtml = $currentOpenBets.html();
                        const newHtml = $newOpenBets.html();
                        
                        if (currentHtml !== newHtml) {
                            // Hay cambios, actualizar con animación suave
                            $currentOpenBets.fadeOut(150, function() {
                                $(this).replaceWith($newOpenBets);
                                $newOpenBets.hide().fadeIn(150);
                            });
                            console.log('✅ Apuestas abiertas actualizadas (nuevas apuestas detectadas)');
                        } else {
                            console.log('ℹ️ No hay cambios en apuestas abiertas');
                        }
                    } else if ($newOpenBets.length && !$currentOpenBets.length) {
                        // Si no existía la sección pero ahora hay apuestas, agregarla
                        if ($noOpenBets.length) {
                            $noOpenBets.parent().fadeOut(150, function() {
                                $(this).replaceWith($newOpenBets);
                                $newOpenBets.hide().fadeIn(150);
                            });
                        } else {
                            // Buscar un contenedor apropiado
                            const $container = $('.sports-card, .game-container').first();
                            if ($container.length) {
                                $container.after($newOpenBets);
                                $newOpenBets.hide().fadeIn(150);
                            }
                        }
                        console.log('✅ Sección de apuestas abiertas agregada (nuevas apuestas disponibles)');
                    } else if (!$newOpenBets.length && $currentOpenBets.length) {
                        // Si ya no hay apuestas abiertas, mostrar mensaje
                        const noOpenBetsHtml = $html.find('.no-open-bets').parent();
                        if (noOpenBetsHtml.length) {
                            $currentOpenBets.fadeOut(150, function() {
                                $(this).replaceWith(noOpenBetsHtml);
                                noOpenBetsHtml.hide().fadeIn(150);
                            });
                            console.log('✅ Todas las apuestas fueron tapadas');
                        }
                    } else {
                        console.log('ℹ️ Sin cambios en apuestas abiertas');
                    }
                    
                    // También actualizar el panel de "Mis Apuestas" solo si está visible
                    const $myBetsTab = $('input[name="bet-type"]:checked');
                    if ($myBetsTab.attr('id') === 'mybets') {
                        const $newMyBets = $html.find('.mybet-container').html();
                        const $currentMyBets = $('.mybet-container').html();
                        
                        if ($newMyBets && $newMyBets !== $currentMyBets) {
                            $('.mybet-container').html($newMyBets);
                            console.log('✅ Mis apuestas actualizadas');
                        }
                    }
                } catch (error) {
                    console.error('❌ Error al procesar HTML:', error);
                }
            },
            error: function(xhr) {
                // Silenciar errores de red para evitar spam en consola
                if (xhr.status !== 0) {
                    console.error('❌ Error al recargar apuestas:', xhr.status);
                }
            }
        });
    };

    // Auto-refrescar apuestas abiertas cada 5 segundos para ver nuevas apuestas de otros usuarios
    let isRefreshing = false;
    
    setInterval(function() {
        // Evitar refrescos simultáneos
        if (isRefreshing) {
            console.log('⏳ Ya hay un refresco en curso, saltando...');
            return;
        }
        
        // Solo refrescar si hay una sección de apuestas abiertas visible
        const $openBetsSection = $('.open-bets-section, .no-open-bets');
        if ($openBetsSection.length === 0) {
            return;
        }
        
        isRefreshing = true;
        window.refreshOpenBets();
        
        // Permitir el siguiente refresco después de 2 segundos
        setTimeout(function() {
            isRefreshing = false;
        }, 2000);
    }, 5000); // Cada 5 segundos para ver apuestas nuevas en tiempo real

    // Inicializar cuando el documento esté listo
    $(document).ready(function() {
        console.log('✅ Sistema de apuestas inicializado');
        console.log('💰 Balance inicial:', getUserBalance());
        
        // Verificar que los elementos existan
        if ($('.oddBtn').length === 0) {
            console.warn('⚠️ No se encontraron botones de odds (.oddBtn)');
        } else {
            console.log('✅ Botones de odds encontrados:', $('.oddBtn').length);
        }
        
        if ($('.bet-amount-btn').length === 0) {
            console.warn('⚠️ No se encontraron botones de monto (.bet-amount-btn)');
        } else {
            console.log('✅ Botones de monto encontrados:', $('.bet-amount-btn').length);
        }
        
        if ($('#betModal').length === 0) {
            console.warn('⚠️ No se encontró el modal de apuestas (#betModal)');
        } else {
            console.log('✅ Modal de apuestas encontrado');
        }

        if ($('.btn-match-bet').length > 0) {
            console.log('✅ Botones de tapar apuesta encontrados:', $('.btn-match-bet').length);
        }
    });

})(jQuery);





