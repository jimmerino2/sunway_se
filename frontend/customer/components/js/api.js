async function getApiResponse(url, method = "GET", body = null) {
  const options = {
    method: method,
    headers: {
      "Content-Type": "application/json",
    },
  };

  if (body && method !== "GET") {
    options.body = JSON.stringify(body);
  }

  const response = await fetch(url, options);
  const rawData = await response.json();

  if (rawData.success) {
    return {
      message: rawData.message,
      data: rawData.data,
    };
  }
}
